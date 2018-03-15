# Admin Codegniter
Gestor de Contenidos

# Configuración inicial
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

# Configuración de los Enlaces para el backend.

Para poder generar los módulos y rutas de edición para el backend se usará un archivo de idioma. El archivo se encuentra en: application/language/espanol/application_lang.php

Ahí se incluirá el siguiente texto por cada enlace agregado en el módulo de menú.

```
<?php

$lang['usuarios'] = "Usuarios"; // usuarios es la ruta que se generó en el menú principal y el texto que se visualizará es "Usuarios"

/* End of file application_lang.php */
/* Location: ./application/language/espanol/application_lang.php */
```
