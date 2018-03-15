# Admin Codegniter
Gestor de Contenidos

Para poder configurar correctamente este repositorio necesitaras ejecutar el SQL que está en la raíz, luego de importarlo. Tendrás que modificar el archivo application/config/database.php

```
$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'root'; // tu usuario de base de datos.
$db['default']['password'] = ''; // la contraseña del usuario.
$db['default']['database'] = 'admin-codeigniter'; // la base de datos.
$db['default']['dbdriver'] = 'mysqli'; // generalmente es mysqli, pero hay servidores que no tienen esta librería, para esos se configura con mysql.
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;
```

Luego tendrás que editar el archivo application/config/config.php

```
...
$config['base_url']	= 'http://localhost/admin-codeigniter/'; // Aquí vas a cambiar la ruta que manejas, ya sea localmente o cuando pases a producción.
...
```
