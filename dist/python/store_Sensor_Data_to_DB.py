#------------------------------------------
#--- Author: Pradeep Singh
#--- Date: 20th January 2017
#--- Version: 1.0
#--- Python Ver: 2.7
#--- Details At: https://iotbytes.wordpress.com/store-mqtt-data-from-sensors-into-sql-database/
#------------------------------------------

import json
import sqlite3
from datetime import datetime

# SQLite DB Name
DB_Name =  "WeatherStation.db"

#===============================================================
# Database Manager Class

class DatabaseManager():
	def __init__(self):
		self.conn = sqlite3.connect(DB_Name)
		self.conn.execute('pragma foreign_keys = on')
		self.conn.commit()
		self.cur = self.conn.cursor()
		
	def add_del_update_db_record(self, sql_query, args=()):
		self.cur.execute(sql_query, args)
		self.conn.commit()
		return

	def __del__(self):
		self.cur.close()
		self.conn.close()

#===============================================================
# Functions to push Sensor Data into Database

# Function to save Temperature to DB Table
def BMP280_Temperature_Data_Handler(jsonData):
	date = (datetime.today()).strftime("%Y-%m-%d")
	time = (datetime.today()).strftime("%H:%M:%S")

	#Parse Data 
	json_Dict = json.loads(jsonData)
	location = json_Dict['Location']
	temperature = json_Dict['Temperature']

	#Push into DB Table
	dbObj = DatabaseManager()
	dbObj.add_del_update_db_record("insert into BMP280_Temperature_Data (Date, Time, Location, Temperature) values (?,?,?,?)",[date, time, location, temperature])
	del dbObj
	print("Inserted Temperature Data into Database.")
	print("")

# Function to save Pressure to DB Table
def BMP280_Pressure_Data_Handler(jsonData):
	date = (datetime.today()).strftime("%Y-%m-%d")
	time = (datetime.today()).strftime("%H:%M:%S")

	#Parse Data 
	json_Dict = json.loads(jsonData)
	location = json_Dict['Location']
	pressure = json_Dict['Pressure']
	
	#Push into DB Table
	dbObj = DatabaseManager()
	dbObj.add_del_update_db_record("insert into BMP280_Pressure_Data (Date, Time, Location, Pressure) values (?,?,?,?)",[date, time, location, pressure])
	del dbObj
	print("Inserted Pressure Data into Database.")
	print("")


# Function to save Light Level to DB Table
def BH1750_Light_Data_Handler(jsonData):
	date = (datetime.today()).strftime("%Y-%m-%d")
	time = (datetime.today()).strftime("%H:%M:%S")

	#Parse Data 
	json_Dict = json.loads(jsonData)
	location = json_Dict['Location']
	light_level = json_Dict['Light_Level']
	
	#Push into DB Table
	dbObj = DatabaseManager()
	dbObj.add_del_update_db_record("insert into BH1750_Light_Data (Date, Time, Location, Light_Level) values (?,?,?,?)",[date, time, location, light_level])
	del dbObj
	print("Inserted Light Level Data into Database.")
	print("")


#===============================================================
# Master Function to Select DB Funtion based on MQTT Topic

def sensor_Data_Handler(Topic, jsonData):
	if Topic == "esp32WeatherStation/Temperature":
		BMP280_Temperature_Data_Handler(jsonData)
	elif Topic == "esp32WeatherStation/Pressure":
		BMP280_Pressure_Data_Handler(jsonData)
	elif Topic == "esp32WeatherStation/Light_Level":
		BH1750_Light_Data_Handler(jsonData)	

#===============================================================
