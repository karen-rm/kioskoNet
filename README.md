# KioskoNet

## Descripción
KioskoNet es una plataforma web que reúne los servicios necesarios para la creación de cuentas, acceso, administración y suscripción a servicios de
distribución de contenido editorial con la adición de un webhook para notificaciones de nuevos títulos.

La plataforma cuenta con un modelo de suscripción individual y empresarial. Mientras que el suscriptor tiene acceso al catálogo al que esté suscrito, las empresas pueden solicitar los
recursos por número de usuarios.

## Demo

### Inicio de sesión:

<img width="1341" height="623" alt="Inicio sesion" src="https://github.com/user-attachments/assets/936f9c18-59b3-45ee-9844-f2d4e835ec2a" />
<hr>

### Registro de usuario: 
<img width="1353" height="628" alt="registro" src="https://github.com/user-attachments/assets/bac52c63-7950-4602-aa87-00afafe2e809" />
<hr>

### Administración de catálogo:
<img width="1251" height="604" alt="catalogo" src="https://github.com/user-attachments/assets/cfc8ab9b-9725-40a3-9fdd-4d73b1747734" />
<br>
<p align="center">
  <img width="536" height="566" alt="AgregarTitulo" src="https://github.com/user-attachments/assets/4ac1f443-03ce-4243-8ce6-4785b2cb87c7" />
</p>
<hr>


### Suscripciones:
<img width="1319" height="606" alt="Suscripciones" src="https://github.com/user-attachments/assets/dfcb4386-fd50-4600-b4cf-8c8b6e37dbac"/>
<br>
<img width="1343" height="348" alt="Buscar suscripciones" src="https://github.com/user-attachments/assets/26dcf0dd-3258-4de1-8326-432eaca7e8b8" />
<hr>

### Cliente: 
<img width="1048" height="469" alt="CatalogoCliente" src="https://github.com/user-attachments/assets/dd8f0e64-2c25-40d0-a4fe-8fbd4fbb66b5" />
<hr>

### Notificaciones cliente: 
<img width="1365" height="245" alt="NotificacionesCliente" src="https://github.com/user-attachments/assets/63fb6f20-dbfb-4f47-ad2f-f85216a357ce" />
<hr> 

### Funcionamiento de webhook:

https://github.com/user-attachments/assets/9ddefe65-1978-4684-bc18-a590c2e6606e

<br> 

## Features

<b>Gestión de usuarios</b>
* Soporte para múltiples roles de usuario (Cliente y Administrador).
* Registro de cuentas de usuario.
* Inicio de sesión.

<b>Acceso al catálogo</b>
* Búsqueda de títulos por nombre.
* Consulta de detalles e información de cada título.
* Visualización del catálogo por parte de los clientes de acuerdo a su suscripción.

<b>Suscripciones</b>
* Adquisición de suscripciones por parte de los usuarios.
* Cancelación de suscripciones en cualquier momento.

<b>Administración y notificaciones</b>
* Registro de nuevos títulos en el sistema.
* Edición de información de títulos por parte del administrador.
* Eliminación de títulos por parte del administrador.
* Notificación automática al cliente cuando se agrega un nuevo título al catálogo.

## Arquitectura
El proyecto presenta una arquitectura en capas, donde el protocolo de comunicación entre cada una de ellas corresponde a una Web API que utiliza diferentes microservicios, desarrollados en PHP y Python.

El producto principal es un servicio de suscripción a periódicos, revistas y libros. Tiene la capacidad de:
1. Dar acceso a todos los títulos de la biblioteca a través de una aplicación web “Cliente”.
2. Se pensó en la asociación con otros tipos de empresas de servicios como: hoteles, aerolíneas, cafés y otras empresas que patrocinan el acceso al servicio para sus clientes.

<img width="4180" height="6880" alt="DiagramaArquitectura" src="https://github.com/user-attachments/assets/3943bf1c-2809-4cc0-81d6-898994f72a16" />

### Tablas de microservicios y operaciones
<p align="center">
  <img width="1027" height="270" alt="Servicios1" src="https://github.com/user-attachments/assets/0269a29b-aad1-44e9-b377-f6b06f0bbe64" />
  <img width="685" height="278" alt="Servicios2" src="https://github.com/user-attachments/assets/e55bb4af-2a23-4a07-a33b-c4ce055263d5" />
</p>

## Tecnologias
- Firebase
- Flask
- Swagger
- Insomnia
- Postman 
- PHP
- Python
- Slim

## Instalación

### Requisitos Previos

Antes de ejecutar el proyecto, asegúrate de tener instalado y configurado:

#### Backend PHP

* PHP 8.0 o superior
* Composer
* Slim Framework 4 (se instala mediante Composer)

#### Backend Python

* Python 3.10 o superior
* Flask
* Flask-CORS

#### Otros

* XAMPP o Apache
* Git
* Firebase (credenciales de servicio)


### 1. Clonar el repositorio

```bash
git clone https://github.com/usuario/KioskoNet.git
cd KioskoNet
```

---

### 2. Instalar dependencias de PHP (Slim 4)

Desde la raíz del proyecto:

```bash
composer install
```

Este comando instalará automáticamente las dependencias definidas en `composer.json`, incluyendo:

* Slim Framework 4
* PSR-7
* Nyholm PSR-7

---

### 3. Instalar dependencias de Python (Flask)

Se recomienda crear un entorno virtual:

```bash
python -m venv venv
```

Activar el entorno virtual:

**Windows**

```bash
venv\Scripts\activate
```

**Linux / macOS**

```bash
source venv/bin/activate
```

Instalar las dependencias:

```bash
pip install flask flask-cors
```

O bien:

```bash
pip install -r requirements.txt
```

---

### 4. Configurar Firebase

Coloca el archivo de credenciales de Firebase:

```text
backend/utils/claveFirebase.json
```

---

### 5. Ejecutar el backend Flask

```bash
python backend/app.py
```

La API Flask estará disponible en:

```text
http://localhost:5000
```

---

### 6. Configurar el servidor PHP

Coloca el proyecto dentro de tu servidor web (por ejemplo, `htdocs` de XAMPP).

Ejemplo:

```text
xampp/
└── htdocs/
    └── KioskoNet/
```

Verifica que el `BasePath` configurado en `public/index.php` coincida con la ubicación del proyecto:

```php
$app->setBasePath("/ServiciosWeb/ProyectoFinal/kioskoNet/public");
```

---

### 7. Ejecutar la aplicación

1. Inicia Apache desde XAMPP.
2. Ejecuta el backend Flask.
3. Accede a la aplicación desde el navegador:

```text
http://localhost/KioskoNet/public
```

---

### Verificación

Si la instalación fue exitosa:

* El frontend cargará correctamente desde Apache.
* Las rutas de Slim Framework responderán desde PHP.
* Los servicios de autenticación, pagos y suscripciones responderán desde Flask.
* Firebase permitirá la autenticación y gestión de usuarios.

## Autores

Proyecto desarrollado por:

- Yuliana Casanova López
- David Martínez Cebada
- Ana Karen Ramírez Martínez
