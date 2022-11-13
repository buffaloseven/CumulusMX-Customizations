#!/usr/bin/env python3

import requests
import argparse
import math

arg_parser = argparse.ArgumentParser(prog = 'Mastodon Auto-Toot', description = 'Programatically send CumulusMX weather conditions to Mastodon.')
arg_parser.add_argument('--domain', help='Domain of your Mastodon instance. For example, https://mstdn.ca')
arg_parser.add_argument('--api_key', help='API key given from the Mastodon developer section.')
arg_parser.add_argument('--cumulus', default="http://localhost:8998", help='API key given from the Mastodon developer section.')
args = arg_parser.parse_args()

# Mastodon Information
mastodon_url = args.domain + "/api/v1/statuses"
mastodon_auth = {'Authorization': 'Bearer ' + args.api_key}

# [ Stuff to collect the info I want in the toot. ]
# [ The pieces of text I need are the summary ]
# [ and URL of the post. They're stored in variables ]
# [ named "summary" and "url." ]

# Get the current conditions from the API
local_api = args.cumulus + "/api/tags/process.json?temp&hum&dew&press&presstrend&rhour&r24hourH&rrate&wspeed&wdir&wgust&avgbearing"
conditions = requests.get(local_api)
if (conditions.status_code == 200):
	conditions = conditions.json()
	print(conditions)
	# Create base temperature string.
	temp_toot = f'''Temperature {conditions["temp"]} °C with a dew point of {conditions["dew"]} °C ({conditions["hum"]}% RH).'''
	
	# Append a wind chill if eligible.
	wind_chill = 13.12 + (0.6215 * float(conditions["temp"])) - (11.37 * pow(float(conditions["wspeed"]),0.16)) + (0.3965 * float(conditions["temp"]) * pow(float(conditions["wspeed"]),0.16))
	wind_chill = round(wind_chill)
	if (wind_chill > 0):
		wind_chill = round(float(conditions["temp"]))
	
	wind_chill_temp_difference = float(conditions["temp"]) - wind_chill
	if (wind_chill < -40):
		temp_toot = temp_toot + f''' Extreme wind chill of {wind_chill}.'''
	elif (wind_chill < -20 and wind_chill_temp_difference > -4):
		temp_toot = temp_toot + f''' Wind chill of {wind_chill}.'''
	elif (wind_chill < -10 and wind_chill_temp_difference > -6):
		temp_toot = temp_toot + f''' Wind chill of {wind_chill}.'''
	
	# Append a humidex if eligible.
	humidex = float(conditions["temp"]) + (0.555 * (6.11 * pow(math.e, 5417.7530*((1/273.16) - (1/(273.15+float(conditions["dew"])))))-10))
	humidex = round(humidex*10) / 10
	humidex_temp_difference = humidex - float(conditions["temp"])
	if (humidex > 40):
		temp_toot = temp_toot + f''' Extreme humidex of {humidex}'''
	elif (humidex > 30 and humidex_temp_difference > 3):
		temp_toot = temp_toot + f''' Humidex humidex of {humidex}'''
	elif (humidex > 20 and humidex_temp_difference > 5):
		temp_toot = temp_toot + f''' Humidex humidex of {humidex}'''
	
	# Pressure component.
	press_toot = f'''Barometer {conditions["press"]} mb, {conditions["presstrend"].lower()}.'''
	
	# Wind component
	if (conditions["wspeed"] == "0"):
		wind_toot = "Winds are calm."
	else:
		wind_toot = f'''Wind {conditions["wdir"]} {conditions["wspeed"]} gusting {conditions["wgust"]} km/h ({conditions["avgbearing"]}°).'''
		
	# Precipitation component
	precip_toot = ""
	if (float(conditions["rrate"]) > 50 and float(conditions["temp"]) > 2):
		precip_toot = precip_toot + f'''Intense rain with a rate of {conditions["rrate"]} mm/hr. '''
	elif (float(conditions["rrate"]) > 7.6 and float(conditions["temp"]) > 2):
		precip_toot = precip_toot + f'''Heavy rain with a rate of {conditions["rrate"]} mm/hr. '''
	elif (float(conditions["rrate"]) > 2.4 and float(conditions["temp"]) > 2):
		precip_toot = precip_toot + f'''Moderate rain with a rate of {conditions["rrate"]} mm/hr. '''
	elif (float(conditions["rrate"]) > 0 and float(conditions["temp"]) > 2):
		precip_toot = precip_toot + f'''Light rain with a rate of {conditions["rrate"]} mm/hr. '''
	
	if (float(conditions["rhour"]) > 0):
		precip_toot = precip_toot + f'''1-hour precipitation of {conditions["rhour"]} mm, {conditions["r24hourH"]} mm last 24 hours.'''
	elif (float(conditions['r24hourH']) > 0):
		precip_toot = precip_toot + f'''24-hour precipitation {conditions["r24hourH"]} mm.'''
	elif (float(conditions["temp"]) < -5):
		precip_toot = precip_toot + f'''No liquid precipitation or melt in the last 24 hours.'''
	else: 
		precip_toot = precip_toot + f'''No precipitaiton in the last 24 hours.'''
	complete_toot = f'''{temp_toot} {press_toot} {wind_toot} {precip_toot}'''
	
	print(complete_toot)
	
	toot = {'status': f'''{complete_toot}'''}
	
	# Send the toot and return its URL.
	r = requests.post(mastodon_url, data=toot, headers=mastodon_auth)
	print(r.json()['uri'])
else:
	print("An error occurred retrieving the data.")