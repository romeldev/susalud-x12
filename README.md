# SUSALUD X12

Paquete PHP/Laravel para generar y parsear tramas X12 EDI utilizadas en las transacciones electrónicas de SUSALUD (Superintendencia Nacional de Salud del Perú).

Soporta las transacciones **270** (consulta de elegibilidad), **271** (respuesta de elegibilidad), **278** (solicitud/respuesta de autorización) y **997** (acuse de recibo funcional).

## Requisitos

- PHP >= 7.2
- Laravel 5.5+ (auto-discovery habilitado) o uso standalone sin framework

## Instalación

```bash
composer require romeldev/susalud-x12
```

Laravel detectará automáticamente el ServiceProvider y el Facade gracias al auto-discovery.

### Publicar configuración (opcional)

```bash
php artisan vendor:publish --tag=susalud-x12-config
```

Esto crea el archivo `config/susalud-x12.php` donde puedes configurar los separadores y el modo de operación:

```php
return [
    'element_separator'   => '*',
    'segment_terminator'  => '~',
    'component_separator' => ':',
    'mode' => env('SUSALUD_X12_MODE', 'T'), // T = Test, P = Producción
];
```

## Uso

### Bean a X12 (serialización)

```php
use Romeldev\SusaludX12\Facades\SusaludX12;
use Romeldev\SusaludX12\Beans\InRegAfi270;

$bean = new InRegAfi270();
$bean->noTransaccion   = '270_REGAFI';
$bean->idRemitente     = '00004210';
$bean->idReceptor      = '10001';
$bean->feTransaccion   = '20250516';
$bean->hoTransaccion   = '090400';
$bean->idCorrelativo   = '000000001';
$bean->idTransaccion   = '270';
$bean->tiFinalidad     = '13';
$bean->caRemitente     = '2';
$bean->nuRucRemitente  = '20230089630';
$bean->caReceptor      = '2';
$bean->caPaciente      = '1';
$bean->tiDocumento     = '1';
$bean->nuDocumento     = '72918104';

// Generar trama X12
$x12 = SusaludX12::regAfi270()->beanToX12($bean);
```

### X12 a Bean (parsing)

```php
use Romeldev\SusaludX12\Facades\SusaludX12;

$tramaX12 = 'ISA*00*          *00*   ...'; // trama X12 completa

$bean = SusaludX12::regAfi270()->x12ToBean($tramaX12);

echo $bean->idRemitente;    // '00004210'
echo $bean->nuRucRemitente; // '20230089630'
echo $bean->nuDocumento;    // '72918104'
```

### Acceso por nombre de servicio

```php
// Equivalente a SusaludX12::regAfi270()
$service = SusaludX12::service('RegAfi270');
$x12 = $service->beanToX12($bean);
```

### Uso directo de converters (sin Facade)

```php
use Romeldev\SusaludX12\Converters\RegAfi270ToX12;
use Romeldev\SusaludX12\Converters\RegAfi270ToBean;

// Bean a X12
$x12 = RegAfi270ToX12::traducirEstructura270($bean);

// X12 a Bean
$bean = RegAfi270ToBean::traducirEstructura270($tramaX12);
```

### Listar servicios disponibles

```php
$servicios = SusaludX12::availableServices();
// ['RegAfi270', 'ConAse270', 'RegAfi271', 'ConCod271', ...]
```

## Transacciones disponibles

### Transacciones 270 (Consulta de elegibilidad)

| Servicio | Facade | Bean | Descripción |
|----------|--------|------|-------------|
| `RegAfi270` | `SusaludX12::regAfi270()` | `InRegAfi270` | Registro de afiliación |
| `ConAse270` | `SusaludX12::conAse270()` | `InConAse270` | Consulta de asegurado |

### Transacciones 271 (Respuesta de elegibilidad)

| Servicio | Facade | Bean | Descripción |
|----------|--------|------|-------------|
| `RegAfi271` | `SusaludX12::regAfi271()` | `InRegAfi271` | Respuesta de registro de afiliación |
| `ConCod271` | `SusaludX12::conCod271()` | `InConCod271` | Consulta por código |
| `ConMed271` | `SusaludX12::conMed271()` | `InConMed271` | Consulta médica |
| `ConNom271` | `SusaludX12::conNom271()` | `InConNom271` | Consulta por nombre |
| `SolAut271` | `SusaludX12::solAut271()` | `InSolAut271` | Solicitud de autorización |
| `In271ConDtad` | `SusaludX12::in271ConDtad()` | `In271ConDtad` | Consulta datos adicionales |
| `In271ConObs` | `SusaludX12::in271ConObs()` | `In271ConObs` | Consulta observaciones |
| `In271ConProc` | `SusaludX12::in271ConProc()` | `In271ConProc` | Consulta procedimientos |
| `In271ResDeriva` | `SusaludX12::in271ResDeriva()` | `In271ResDeriva` | Respuesta derivación |
| `In271ResSctr` | `SusaludX12::in271ResSctr()` | `In271ResSctr` | Respuesta SCTR |
| `LogAcreInsert271` | `SusaludX12::logAcreInsert271()` | `InLogAcreInsert271` | Log acreditación inserción |

### Transacciones 278 (Autorización de servicios)

| Servicio | Facade | Bean | Descripción |
|----------|--------|------|-------------|
| `In278SolCG` | `SusaludX12::in278SolCG()` | `In278SolCG` | Solicitud carta garantía |
| `In278ResCG` | `SusaludX12::in278ResCG()` | `In278ResCG` | Respuesta carta garantía |
| `ConEntVinc278` | `SusaludX12::conEntVinc278()` | `InConEntVinc278` | Consulta entidad vinculada |
| `ResEntVinc278` | `SusaludX12::resEntVinc278()` | `InResEntVinc278` | Respuesta entidad vinculada |

### Transacciones 997 (Acuse funcional)

| Servicio | Facade | Bean | Descripción |
|----------|--------|------|-------------|
| `In997ResAut` | `SusaludX12::in997ResAut()` | `In997ResAut` | Respuesta de autorización |

## Validación

Cada transacción cuenta con un validador que verifica campos requeridos, longitudes y formatos:

```php
use Romeldev\SusaludX12\Validators\RegAfiValidator;

$errores = RegAfiValidator::validate($bean);

if (!empty($errores)) {
    // $errores contiene los códigos de error
    foreach ($errores as $error) {
        echo $error;
    }
}
```

## Testing

```bash
composer test
```

## Estructura del paquete

```
src/
├── Beans/              # DTOs para cada transacción
│   └── Detalle/        # Beans de detalle (líneas de items)
├── Converters/         # Conversión Bean↔X12 (36 archivos)
├── Facades/            # Facade de Laravel
├── Segments/           # Segmentos X12 (ISA, GS, ST, NM1, etc.)
├── Services/           # Servicios por transacción + Manager
│   └── Contracts/      # Interfaz TransactionServiceInterface
├── Support/            # Utilidades
└── Validators/         # Validadores por transacción
```

## Licencia

MIT
