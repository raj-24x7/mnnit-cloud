#!/bin/bash
echo  NO.  of argu$#

#IP Settings

#ip[0]="172.31.103.5"
#ip[1]="172.31.103.6"
#ip[2]="172.31.103.7"
#ip[3]="172.31.103.8"
#ip[4]="172.31.103.9"

mask="255.255.252.0"

gateway="172.31.128.1"

if test $# -lt 3 
then
	echo Improper usage use following: 
	echo  $0 nameOfCluster memory  num_of_nodes
	exit
fi

name=$1
memory=$2
num_of_vm=$3


# IP Settings
k=0
for i in $@; do
	k=$(($k+1))
    if test $k -gt 3
    then
    	ip[$k-4]=$i
	fi
done


masterName=$1Master
slaveName=$1Slave

echo $masterName;
echo $slaveName;
#setup machine names
name=$masterName
ips=${ip[0]}
  
for ((i=1; i<=$num_of_vm; i++))
do
	name="$name#$slaveName$i"
	echo ${ip[$i]}
	ips="$ips#${ip[$i]}"
done

echo $name
echo $ips


#createMaster

m_uuid=$(xe vm-install template="masterTemp" new-name-label=$masterName)
xe vm-memory-limits-set dynamic-max=$2 dynamic-min=$2 static-max=$2 static-min=$2 name-label=$masterName 

xe vm-param-set uuid=$m_uuid PV-args="graphical utf8 -- _ipaddr=${ip[0]} _netmask=$mask _gateway=$gateway _hostname=$masterName _name=$name _ip=$ips"

xe vm-start vm=$masterName
echo Plz wait while $masterName starts.....
sleep 15
xe vm-reboot  uuid=$m_uuid force=true

#createSlaves

for ((i=1; i<=$num_of_vm; i++))
do
	s_uuid=$(xe vm-install template="slaveTemp" new-name-label=$slaveName$i)
	xe vm-memory-limits-set dynamic-max=$2 dynamic-min=$2 static-max=$2 static-min=$2 name-label=$slaveName$i 

	xe vm-param-set uuid=$s_uuid PV-args="graphical utf8 -- _ipaddr=${ip[$i]} _netmask=$mask _gateway=$gateway _hostname=$slaveName$i _name=$name _ip=$ips"

xe vm-start vm=$slaveName$i
echo Plz wait while $slaveName$i starts.....
sleep 15
xe vm-reboot  uuid=$s_uuid force=true
done

