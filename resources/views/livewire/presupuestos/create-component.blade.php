@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
    @vite(['resources/sass/presupuestos.scss'])
@endsection



<div class="container mx-auto">
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <h1>Presupuestos</h1>
    <h2>Crear presupuesto</h2>
    <br>
    <div class="d-flex justify-content-evenly align-items-center">
        <h4 class="">Seleccione el tipo de cliente</h4>
    </div>
    <div class="d-flex justify-content-evenly align-items-center mb-4">
        <div>
            <input type="radio" name="empresa" id="particular" value="1" class="form-check-input"
                wire:model="tipoCliente">&nbsp; Particular
        </div>
        <div>
            <input type="radio" name="empresa" id="empresa" value="2" class="form-check-input"
                wire:model="tipoCliente">&nbsp; Empresa
        </div>
    </div>

    <div class="card">
        <h4 class="card-header" style="border-bottom: 1px solid darkgray;">Datos básicos del presupuesto @if ($tipoCliente == 1)
                para particular
            @else
                para empresa
            @endif
        </h4>
        <div class="card-body">
            <form wire:submit.prevent="submit">
                <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">

                <div class="mb-3 row d-flex align-items-center">
                    <label for="numero_presupuesto" class="col-sm-2 col-form-label">Número de presupuesto</label>
                    <div class="col-sm-10">
                        <input type="text" wire:model="numero_presupuesto" class="form-control"
                            name="numero_presupuesto" id="numero_presupuesto">
                        @error('numero_presupuesto')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row d-flex align-items-center">
                    <label for="fecha_fin" class="col-sm-2 col-form-label">Fecha de emisión del presupuesto</label>
                    <div class="col-sm-10">
                        <input type="date" wire:model="fecha_fin" class="form-control" id="datepicker">
                        @error('fecha_fin')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @if ($tipoCliente == 2)
                    <div class="mb-3 row">
                        <label for="empresa-select" class="col-sm-2 col-form-label">Empresa</label>
                        <div class="col-sm-10">
                            <div class="form-group input-group mb-2" x-data="{}" x-init="$('#empresa-select').select2({
                                tags: true
                            });
                            $('#empresa-select').on('change', function(e) {
                                @this.set('empresa_id', $('#empresa-select').val());
                            });"
                                wire:key="{{ rand() }}">
                                <select id="empresa-select" class="form-control" wire:model="empresa_id">
                                    <option value="0">-- Empresas registradas --</option>
                                    @foreach ($empresaSeleccionar as $emp)
                                        <option value="{{ $emp->id }}">{{ $emp->nombre }} </option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" class="form-control" placeholder="Nombre" wire:model="nameProducto.0"> --}}
                                @error('nameProducto.0')
                                    <span class="text-danger error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif
                <div class="mb-3 row d-flex align-items-center">
                    <label for="fecha_inicio" class="col-sm-2 col-form-label">Posibles fechas de cursos</label>
                    <div class="col-sm-10">
                        <button type="button" class="btn btn-primary" wire:click.prevent="addFecha">Añadir</button>
                    </div>
                </div>
                <div class="mb-3 row d-flex align-items-center">
                    <label for="fecha_inicio" class="col-sm-2 col-form-label">&nbsp;</label>
                    <div class="col-sm-10">
                        @if (empty($posibles_fechas))
                        @else
                            <table class="table" width="100%">
                                <tr width="100%">
                                    <th width="10%"></th>
                                    <th width="45%">Desde...</th>
                                    <th width="45%">Hasta...</th>
                                </tr>
                                @foreach ($posibles_fechas as $rangoIndex => $rango)
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-secondary"
                                                disabled>{{ $rangoIndex + 1 }}</button>
                                        </td>
                                        <td>
                                            <input type="date"
                                                wire:model="posibles_fechas.{{ $rangoIndex }}.fecha_1"
                                                class="form-control">
                                            @error('numero_presupuesto')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td class="col-sm-3">
                                            <input type="date"
                                                wire:model="posibles_fechas.{{ $rangoIndex }}.fecha_2"
                                                class="form-control">
                                            @error('numero_presupuesto')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
                <div class="mb-3 row d-flex align-items-center">
                    <label for="monitor" class="col-sm-2 col-form-label">Monitor</label>
                    <div class="col-sm-10" wire:ignore.self>
                        <select id="monitor" class="form-control js-example-responsive" wire:model="monitor_id">
                            <option value=" Pendiente"></option>
                            @foreach ($monitores as $monitor)
                                <option value="{{ $monitor->id }}">{{ "$monitor->nombre $monitor->apellidos" }}
                                </option>
                            @endforeach
                        </select>
                        @error('denominacion')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row d-flex align-items-center">
                    <label for="detalles" class="col-sm-2 col-form-label">Detalles</label>
                    <div class="col-sm-10">
                        <input type="text" wire:model="detalles" class="form-control" name="detalles"
                            id="detalles">
                        @error('detalles')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row d-flex align-items-center">
                    <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                    <div class="col-sm-10" wire:ignore.self>
                        <select id="estado" class="form-control js-example-responsive" wire:model="estado">
                            <option value=" Pendiente">-- Seleccione un estado para el presupuesto--</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Aceptado">Aceptado</option>
                            <option value="Rechazado">Rechazado</option>
                        </select>
                        @error('denominacion')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row d-flex align-items-center">
                    <label for="observaciones" class="col-sm-2 col-form-label">Observaciones</label>
                    <div class="col-sm-10">
                        <input type="text" wire:model="observaciones" class="form-control" name="observaciones"
                            id="observaciones">
                        {{-- @error('observaciones') <span class="text-danger">{{ $message }}</span> @enderror --}}
                    </div>
                </div>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-header">
            <div class="row">
                <h4 class="col-8">Datos de alumnos y asignación de cursos</h4>
                <div class="col-2">
                    <button type="button" class="btn text-white btn-info w-100" wire:click="add()">Añadir
                        alumno</button>
                </div>
                <div class="col-2">
                    <button type="button" class="btn text-white btn-info w-100 ML-1" wire:click="addUndefinedAlumnosGroup()">Alumnos Sin Definir</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table" width="100%">
                <thead>
                    <tr>
                        @if ($numero_alumnos >= 1)
                        <th width="10%">Nº alumnos</th>
                    @else
                    <th width="20%">Alumno</th>
                    <th width="10%">DNI</th>
                    <th width="10%">¿Tiene segundo apellido?</th>
                    @endif
                    <th width="20%">Curso</th>
                    <th width="10%">¿Atiende más de un curso?</th>
                    <th width="10%">Precio</th>
                    <th width="10%">Horas</th>
                    <th width="5%">Certificado</th>
                    <th width="5%">Eliminar</th>
                    </tr>
                </thead>
                @for ($i = count($alumnos) - 1; $i >= 0; $i--)
                    @php
                        $alumnoKey = $i;
                        $alumnoValue = $alumnos[$i];
                    @endphp
                    <tbody>
                        @if ($numero_alumnos >= 1)
                        <td>
                            <input type="number" wire:model="numero_alumnos" class="form-control"></td>
                    @else
                        <tr>
                        <td x-data="{}" x-init="$('#alumnosSelect{{ $alumnoKey }}').select2({
                            tags: true
                        });
                        $('#alumnosSelect{{ $alumnoKey }}').on('change', function(e) {
                            @this.set('alumnos.{{ $alumnoKey }}.alumno', $('#alumnosSelect{{ $alumnoKey }}').val());
                            @this.addAlumnoSelect($('#alumnosSelect{{ $alumnoKey }}').val());
                            @this.getDNI({{ $alumnoKey }});
                        });" width="20%"
                            wire:key="{{ rand() }}">
                            <select wire:model="alumnos.{{ $alumnoKey }}.alumno" class="form-control"
                                name="observaciones" id="alumnosSelect{{ $alumnoKey }}" wire:ignore.self>
                                <option value=""></option>
                                <option value="0">-- Nuevo alumno --</option>
                                @foreach ($empresaSeleccionar as $emp)
                                    <optgroup label="{{ $emp->nombre }}">
                                        @foreach ($alumnosSinEmpresa->where('empresa_id', $emp->id) as $alumn)
                                            <option value="{{ $alumn->id }}"> {{ $alumn->nombre }}
                                                {{ $alumn->apellidos }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                                <optgroup label="Alumnos particulares (sin empresa)">
                                    @foreach ($alumnosSinEmpresa->where('empresa_id', 0) as $alumn)
                                        <option value="{{ $alumn->id }}"> {{ $alumn->nombre }}
                                            {{ $alumn->apellidos }}
                                        </option>
                                    @endforeach
                                    @foreach ($alumnos_select as $alumno_select)
                                        <option value="{{ $alumno_select }}">{{ $alumno_select }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            {{-- <input type="text" class="form-control" placeholder="Nombre" wire:model="nameProducto.0"> --}}
                            @error('nameProducto.0')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </td>
                        <td width="10%"><input type="text" class="form-control"
                                wire:model="alumnos.{{ $alumnoKey }}.dni" placeholder="DNI">
                            @error('precio.0')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </td>
                        <td width="10%"> <input type="checkbox"
                                wire:model="alumnos.{{ $alumnoKey }}.segundo_apellido"> </td>
                    @endif
                        <td x-data="{}" x-init="$('#cursosSelect{{ $alumnoKey }}').select2({
                            tags: true
                        });
                        $('#cursosSelect{{ $alumnoKey }}').on('change', function(e) {
                            @this.set('alumnos.{{ $alumnoKey }}.curso', $('#cursosSelect{{ $alumnoKey }}').val());
                            @this.addCursoSelect($('#cursosSelect{{ $alumnoKey }}').val());
                            @this.addPrecio({{ $alumnoKey }});
                        });" width="20%"
                            wire:key="{{ rand() }}">
                            <select name="producto" id="cursosSelect{{ $alumnoKey }}"
                                wire:model="alumnos.{{ $alumnoKey }}.curso" class="form-control">
                                <option value="">-- Elige un curso --</option>
                                <option value="0">-- Nuevo curso --</option>
                                @foreach ($cursos as $curso)
                                    <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                                @endforeach
                                @foreach ($cursos_select as $curso_select)
                                    <option value="{{ $curso_select }}">{{ $curso_select }}</option>
                                @endforeach
                            </select>
                            {{-- <input type="text" class="form-control" placeholder="Nombre" wire:model="nameProducto.0"> --}}
                            @error('nameProducto.0')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </td>
                        <td width="10%"> <input type="checkbox"
                                wire:model="alumnos.{{ $alumnoKey }}.cursoMultiple">
                            @if ($alumnoValue['cursoMultiple'] == true)
                                <button class="btn btn-primary btn-sm"
                                    wire:click.prevent="addCurso({{ $alumnoKey }})">+</button>
                            @endif
                        </td>
                        <td width="10%">
                            <input type="number" step="any" class="form-control"
                                wire:change="updateTotalPrice" wire:model="alumnos.{{ $alumnoKey }}.precio"
                                placeholder="Precio Total">
                            @error('precio.0')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </td>
                        <td width="10%">
                            <input type="number" step="any" class="form-control"
                                wire:change="updateTotalPrice" wire:model="alumnos.{{ $alumnoKey }}.horas"
                                placeholder="Precio Total">
                            @error('precio.0')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </td>
                        <td width="5%">
                            <button class="btn text-white btn-info btn-sm"
                                wire:click.prevent="verCertificado({{ $alumnoKey }})">Ver certificado</button>
                        </td>
                        <td width="5%">
                            <button class="btn text-white btn-danger btn-sm"
                                wire:click.prevent="removeInput({{ $i }})">X</button>
                        </td>
                    </tr>
                    @if ($alumnoValue['cursoMultiple'] == true && isset($cursos_multiples[$alumnoKey][0]))
                        @foreach ($cursos_multiples[$alumnoKey] as $multipleKey => $curso_multiple)
                            <tr>
                                <td width="30%">
                                    &nbsp;
                                </td>
                                <td width="10%"> &nbsp; </td>
                                <td width="10%"> &nbsp; </td>
                                <td x-data="{}" x-init="$('#cursosSelect{{ $multipleKey }}-{{ $alumnoKey }}').select2({
                                    tags: true
                                });
                                $('#cursosSelect{{ $multipleKey }}-{{ $alumnoKey }}').on('change', function(e) {
                                    @this.set('cursos_multiples.{{ $alumnoKey }}.{{ $multipleKey }}.curso', $('#cursosSelect{{ $multipleKey }}-{{ $alumnoKey }}').val());
                                    @this.addCursoSelect($('#cursosSelect{{ $multipleKey }}-{{ $alumnoKey }}').val());
                                    @this.addPrecioMultiple({{ $alumnoKey }}, {{ $multipleKey }});
                                });" width="20%"
                                    wire:key="{{ rand() }}">
                                    <select name="producto"
                                        id="cursosSelect{{ $multipleKey }}-{{ $alumnoKey }}"
                                        wire:model="cursos_multiples.{{ $alumnoKey }}.{{ $multipleKey }}.curso"
                                        class="form-control">
                                        <option value="">-- Elige un curso --</option>
                                        <option value="0">-- Nuevo curso --</option>
                                        @foreach ($cursos as $curso)
                                            <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                                        @endforeach
                                        @foreach ($cursos_select as $curso_select)
                                            <option value="{{ $curso_select }}">{{ $curso_select }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <input type="text" class="form-control" placeholder="Nombre" wire:model="nameProducto.0"> --}}
                                    @error('nameProducto.0')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td width="10%"> &nbsp; </td>
                                <td width="10%">
                                    <input type="number" step="any" class="form-control"
                                        wire:change="updateTotalPrice"
                                        wire:model="cursos_multiples.{{ $alumnoKey }}.{{ $multipleKey }}.precio"
                                        placeholder="Precio Total">
                                    @error('precio.0')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td width="10%">
                                    <input type="number" step="any" class="form-control"
                                        wire:change="updateTotalPrice"
                                        wire:model="cursos_multiples.{{ $alumnoKey }}.{{ $multipleKey }}.horas"
                                        placeholder="Precio Total">
                                    @error('precio.0')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td width="10%">
                                    <button class="btn text-white btn-info btn-sm"
                                        wire:click.prevent="verCertificadoMultiple({{ $alumnoKey }}, {{ $multipleKey }})">Ver
                                        certificado</button>
                                </td>
                                <td width="10%">
                                    <button class="btn text-white btn-danger btn-sm"
                                        wire:click.prevent="removecurso({{ $alumnoKey }}, {{ $multipleKey }})">X</button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
            @endfor
                </tbody>
            </table>
            <br>
            <br>
            @if ($stateAlumno != 0)
                <div class="mb-3 row d-flex align-items-center">
                    <label for="dni_alumno" class="col-sm-2 col-form-label">DNI alumno</label>
                    <div class="col-sm-10">
                        <input readOnly type="text" placeholder="{{ $alumnoSeleccionado->dni }}"
                            class="form-control" name="dni_alumno" id="dni_alumno">
                        @error('dni_alumno')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="card mt-5">
        <h4 class="card-header"> Total </h4>
        <div class="card-body">
            <table class="table" width="100%">
                <tr>
                    <th>Precio total (Sin impuestos incluidos):</th>
                    <th>Descuento:</th>
                    <th>Precio total (Con descuento y sin impuestos incluidos):</th>
                </tr>
                <tr>
                    <td><input type="text" step="any" class="form-control" disabled wire:model="precio"
                            placeholder="Precio Total"></td>
                    <td><input type="number" step="any" class="form-control" wire:change="addDiscount"
                            wire:model="descuento" placeholder="Descuento"></td>
                    <td><input type="text" step="any" class="form-control" disabled
                            wire:model="precioConDescuento" placeholder="Precio Total (Con descuento)"></td>
                </tr>
            </table>
            <table class="table" width="100%">
                <tr>
                    <th>Precio total (Con impuestos):</th>
                    <th>Precio total (Con descuento e impuestos):</th>
                </tr>
                <tr>
                    <td>{{ number_format($precio * 0.21 + $precio, 2, ',', '.') }}
                    </td>
                    <td>{{ number_format($precioConDescuento * 0.21 + $precio, 2, ',', '.') }}</td>
                </tr>

            </table>
        </div>
    </div>


    <div class="mb-5 mt-5 row d-flex align-items-center">
        <button type="submit" class="btn btn-outline-info mb-5">Guardar</button>
    </div>

    </form>

</div>


@section('scripts')
    <script>
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '< Ant',
            nextText: 'Sig >',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'
            ],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
    </script>

    <script>
        // Livewire.on('calcularPrecio');
    </script>
@endsection
