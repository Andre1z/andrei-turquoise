# Andrei | Turquois

Descripción:
------------
Esta aplicación web está desarrollada en PHP y utiliza SQLite para el almacenamiento de datos. La solución implementa:

  • Sistema de autenticación de usuarios (login / registro)
  • Un dashboard con información básica del usuario
  • Un panel de administración que permite gestionar dos tablas principales:
      - Restaurantes
      - Reservas
  • Operaciones CRUD completas en cada una de las tablas: 
      - Crear, leer, actualizar y eliminar registros.
  • Inserción de datos de ejemplo mediante scripts y archivo JSON.
  • Estilos visuales vibrantes y modernos, con archivos CSS externos para cada apartado.

Características principales:
----------------------------
- **Autenticación:** Inicia sesión y gestiona el perfil del usuario.
- **Dashboard:** Página inicial tras el login, que conecta con las distintas funcionalidades.
- **Gestión de Restaurantes:** Permite visualizar, crear, editar y eliminar registros de restaurantes.
- **Gestión de Reservas:** Permite visualizar, crear, editar y eliminar registros de reservas.
- **Estilos y Diseño:** Uso de un fondo degradado, colores vivos y transiciones para crear una experiencia visual impactante.
- **Ruteo Simple:** El archivo `index.php` se encarga de redirigir a las diferentes vistas según la URL.

Instalación y Configuración:
----------------------------
1. **Requisitos:**
   - PHP 7.x o superior.
   - Extensión SQLite habilitada en PHP.
   - Servidor web local (por ejemplo, XAMPP, WAMP o el servidor incorporado de PHP).

2. **Estructura de Archivos:**
   - `/public`: Contiene el frontend de la aplicación (index.php, archivos de vistas, CSS, JavaScript).
   - `/config`: Archivos de configuración (por ejemplo, config.php).
   - `/core`: Clases principales como Database.php.
   - `/database`: Scripts para crear las tablas (create_restaurants_table.php, create_reservations_table.php), el archivo JSON con datos de ejemplo (sample_data.json) y el archivo de inserción de datos (insert_sample_data.php).

3. **Instalación:**
   - Copia o clona los archivos en el directorio raíz de tu servidor web.
   - Asegúrate de que la carpeta `/database` permita escribir (para la creación y actualización del archivo `database.sqlite`).
   - Ejecuta los scripts de creación de tablas (primero sin restricciones de keys, después actualiza según tus necesidades).
      Ejemplo:  
         php create_restaurants_table.php  
         php create_reservations_table.php  
         php insert_sample_data.php
   - Accede a la aplicación a través del navegador (por ejemplo, http://localhost/andrei-turquois/public/index.php).

Uso:
-----
1. **Inicio:** Accede mediante el login (o registro) a la aplicación.
2. **Dashboard:** Desde el dashboard se puede navegar a las diferentes secciones (Perfil y Restaurantes).
3. **Gestión de Datos:** En el apartado de "Restaurantes" encontrarás:
   - La lista completa de registros de Restaurantes y Reservas.
   - Opciones para crear nuevos registros en ambas tablas.
   - Opciones para editar o eliminar registros existentes.
4. **Estilos:** Los archivos CSS se encuentran en `/public/css`, y están diseñados para ofrecer una apariencia visual vibrante y moderna.

Personalización:
----------------
- Puedes modificar los estilos en los archivos de la carpeta `/public/css` para adaptar la identidad visual según lo requerido.
- El ruteo se maneja en `index.php`. Puedes agregar o ajustar nuevas rutas según se amplíe la funcionalidad.
- La conexión a la base de datos se administra en `core/Database.php`. Si deseas utilizar otro sistema (p.ej., MySQL), deberás ajustar esa clase.

Soporte y Contacto:
--------------------
Desarrollado por Andrei buga.  
Si tienes alguna duda o necesitas soporte, contáctame en: bugaandrei1@gmail.com.

--------------------------------------------------