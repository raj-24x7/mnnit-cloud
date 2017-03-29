#!/bin/bash

function setNetwork()
{
  IP=$1
  NETMASK=$2
  GATEWAY=$3 
  ifconfig eth0  $IP;
  ifconfig eth0 netmask $NETMASK;
  route add default gw $GATEWAY;
  echo "Inside setNetwork"
}

function setHostName()
{
  HOSTNAME=$1
  hostn=$(cat /etc/hostname)
  sed -i "s/$hostn/$HOSTNAME/g" /etc/hostname
  echo "Inside setHostname"
}

function setMasterSlaves()
{
   echo "Inside setmaster"
   hosts=$1
   ips=$2
   IFS=#
   ary=($hosts)
   aryIp=($ips)

   >/usr/local/hadoop/etc/hadoop/master 
   >/usr/local/hadoop/etc/hadoop/slaves
   >/etc/hosts
   echo 127.0.0.1   localhost >> /etc/hosts
   for key in "${!ary[@]}";
   do 
      echo "${ary[$key]}";    
      if [ $key -eq 0 ];
        then
        echo "${ary[$key]}" > /usr/local/hadoop/etc/hadoop/master;
        i=2;
      fi
      
      if [ $key -ne 0 ];
        then
      echo "${ary[$key]}" >> /usr/local/hadoop/etc/hadoop/slaves ;
      fi
      echo "${aryIp[$key]}" "${ary[$key]}">> /etc/hosts;
   done

  sed -i "s/master/${ary[0]}/g" //usr/local/hadoop/etc/hadoop/mapred-site.xml
  sed -i "s/master/${ary[0]}/g" //usr/local/hadoop/etc/hadoop/yarn-site.xml
  sed -i "s/master/${ary[0]}/g" //usr/local/hadoop/etc/hadoop/core-site.xml
}

function setHosts()
{
  echo "Inside setSlaves"
}

OPTIONS=$(cat /proc/cmdline|sed 's/.*--//g')
echo $OPTIONS

for i in $OPTIONS
  do
    OPT=$(echo $i|cut -f 1 -d "=")
    VAL=$(echo $i|cut -f 2 -d "=")

    if [ "${OPT:0:1}" = "_" ]
      then
        case $OPT in
        _ipaddr)
          IP=$VAL;;
          _netmask)
          NETMASK=$VAL;;
        _gateway)
           GATEWAY=$VAL;;
        _hostname)
           HOSTNAME=$VAL;;
        _ip)
          HOSTIP=$VAL;;
        _name)
          HOSTS=$VAL;;
        esac
    fi
  done  

#serviice network restart

#set Network
setNetwork $IP $NETMASK $GATEWAY;

#set hostname 
setHostName $HOSTNAME;

#set MasterSlave
#setMasterSlaves  $HOSTS $HOSTIP;


exit
