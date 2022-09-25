## Host Check Command
### Install as monitoring user

```
make install
```

```
host-grab-check "$HOSTNAME$" "$HOSTADDRESS$" "$_HOSTTAGS$"

# Label: HOST:PASSIVE
```

![Passive Host Setup](.github/host-passive.png)


##

```
grab-check  "$HOSTNAME$" "$HOSTADDRESS$" "$_HOSTTAGS$"

# Label: DS:PASSIVE"
```

![Passive Check Setup](.github/check-passive.png)

## Apache

```
mkdir -p /var/www/acme
apt-get update -qq && apt-get install -qq libapache2-mod-php
```

## Check storage dir
```
u=monitoring
{
  mkdir -p -m 770 /var/lib/monitoring/passive
  chown ${u}:${u} /var/lib/monitoring/passive
  apt-get update -qq && apt-get install -qq acl
  setfacl -m d:u:${u}:rwx,u:${u}:rwx /var/lib/monitoring/passive
  setfacl -m d:u:www-data:rwx,u:www-data:rwx /var/lib/monitoring/passive
}
```
