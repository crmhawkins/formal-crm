<?php

namespace App\Http\Livewire\Empresas;

use App\Models\Empresa;
use App\Models\Localidad;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CreateComponent extends Component
{

    use LivewireAlert;

    public $nombre;
    public $telefono;
    public $direccion;
    public $cif;
    public $email;
    public $cod_postal;
    public $localidad;
    public $pais;
    public $persona_contacto;
    public $persona_contacto_telefono;




    public function mount(){
    }

    public function render()
    {
        return view('livewire.empresas.create-component');
    }

    public function cambiarCodPostal()
    {
        $localidad = Localidad::where('cod_postal', $this->cod_postal)->first();

        if ($localidad) {
            $this->localidad = $localidad->poblacion;
        }
    }

    public function cambiarLocalidad()
    {
        $localidad = Localidad::where('localidad', $this->localidad)->first();

        if ($localidad) {
            $this->cod_postal = $localidad->cod_postal;
        }
    }

    // Al hacer submit en el formulario
    public function submit()
    {
        // Validación de datos
        $validatedData = $this->validate([
            'nombre' => '',
            'telefono' => '',
            'direccion' => '',
            'cif' => '',
            'email' => '',
            'cod_postal' => '',
            'localidad' => '',
            'pais' => '',
            'persona_contacto' => '',
            'persona_contacto_telefono' => '',

        ],
            // Mensajes de error
            [
                // 'nombre.required' => 'El nombre es obligatorio.',
                // 'telefono.required' => 'El teléfono es obligatorio.',
                // 'direccion.required' => 'La dirección es obligatoria.',
                // 'cif.required' => 'El CIF es obligatorio.',
                // 'email.required' => 'El email es obligatorio.',
                // 'email.regex' => 'Introduce un email válido',
                // 'cod_postal.required' => 'El código postal es obligatorio.',
                // 'localidad.required' => 'La localidad es obligatoria.',
                // 'pais.required' => 'El país es obligatorio.',
            ]);

        // Guardar datos validados
        $empresasSave = Empresa::create($validatedData);

        // Alertas de guardado exitoso
        if ($empresasSave) {
            $this->alert('success', '¡Empresa registrada correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información de la empresa!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }

    // Función para cuando se llama a la alerta
    public function getListeners()
    {
        return [
            'confirmed',
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('empresas.index');

    }
}
