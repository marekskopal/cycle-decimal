# Cycle ORM - Decimal support

Decimal type from ext-decimal PHP extension support for Cycle ORM.


## Install

```sh
composer require marekskopal/cycle-decimal
```

## Usage

Add `DecimalTypecast` to your entity typecast list and use Decimal type in your entity.

```php
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\ORM\Parser\Typecast;
use Decimal\Decimal;
use MarekSkopal\Cycle\Decimal\DecimalTypecast;

#[Entity(
    typecast: [
        Typecast::class,
        DecimalTypecast::class,
    ]
)]
class MyEntity
{
    #[Column(type: 'decimal(8,2)', typecast: DecimalTypecast::Type)]
    public Decimal $value;
    
        #[Column(type: 'decimal(8,2)', typecast: 'decimal(8,2)')]
    public Decimal $valueWithPrecision;
}
```

