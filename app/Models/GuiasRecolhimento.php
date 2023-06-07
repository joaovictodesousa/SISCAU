<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuiasRecolhimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'auxtiporecolhimentoid',
        'auxinstituicaofinanceiraid',
        'auxagenciaid',
        'auxempresaid',
        'datagr',
        'datavalidade',
        'auxtipodocumentoid',
        'numero',
        'numeroconta',
        'numerocontrato',
        'aditivo',
        'valor',
        'numerodocumento',
        'numeronl',
        'numeronl'
    ];
}
