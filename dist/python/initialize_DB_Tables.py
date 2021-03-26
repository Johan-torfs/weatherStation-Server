#------------------------------------------
#--- Author: Pradeep Singh
#--- Date: 20th January 2017
#--- Version: 1.0
#--- Python Ver: 2.7
#--- Details At: https://iotbytes.wordpress.com/store-mqtt-data-from-sensors-into-sql-database/
#------------------------------------------

import sqlite3

# SQLite DB Name
DB_Name =  "WeatherStation.db"

# SQLite DB Table Schema
TableSchema="""
drop table if exists BMP280_Temperature_Data ;
create table BMP280_Temperature_Data (
  id integer primary key autoincrement,
  Date text,
  Time text,
  Location text,
  Temperature float
);


drop table if exists BMP280_Pressure_Data ;
create table BMP280_Pressure_Data (
  id integer primary key autoincrement,
  Date text,
  Time text,
  Location text,
  Pressure float
);


drop table if exists BH1750_Light_Data ;
create table BH1750_Light_Data (
  id integer primary key autoincrement,
  Date text,
  Time text,
  Location text,
  Light_Level float
);
"""

#Connect or Create DB File
conn = sqlite3.connect(DB_Name)
curs = conn.cursor()

#Create Tables
sqlite3.complete_statement(TableSchema)
curs.executescript(TableSchema)

#Close DB
curs.close()
conn.close()
