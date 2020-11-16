<div x-data="{open:false}" class="text-gray-500">
    <button @click="open=true">Ver</button>
    <div @click.away="open=false" class=" bg-white flex gap-1 p-16 fixed w-full overflow-auto inset-0 h-screen " x-show="open">
        <div class="w-10/12 flex flex-wrap">
            <div class="w-full">
                @if ($action == 'view')            
                    <p class="text-2xl text-gray-500">{{$course->title}}</p>
                    <p class=" text-gray-500">{{$course->description}}</p>
                    <button wire:click="setAction">Editar</button>
                @endif
                @if ($action == 'update')
                    <div class="flex flex-col gap-3 justify-center">
                        <input type="text" wire:model.defer="title" class="p-3 border-2 border-gray-200 rounded-lg">
                        <textarea type="text" wire:model.defer="description" class="p-3 border-2 border-gray-200 rounded-lg"></textarea>
                        <input type="number" wire:model.defer="capacity" class="border-2 border-gray-200 rounded-lg p-3 w-64">
                        <div class="flex gap-3">
                            <button class="p-3 text-white rounded-lg bg-green-500" wire:click="save">Guardar</button>
                            <button class="p-3 text-white rounded-lg bg-red-500" wire:click="cancel">cancelar</button>
                        </div>
                    </div>
                @endif
            </div>
            <div class="w-1/2 p-2">
                @livewire('schedule.create', ['course' => $course])
            </div>
            <div class="w-1/2 p-2">
                @livewire('thematic.create', ['course' => $course])
            </div>
        </div>
        <div class="w-2/12 flex flex-col gap-2">
            <div class="border-2 border-gray-200 rounded-md p-1">
                <p class="text-xl">Tutores activos</p>
                @if (count($this_tutors)>0)
                    @foreach ($this_tutors as $tutor)
                        <div class="flex w-full justify-between p-3 items-center">
                            <p>{{$tutor->name}}</p>
                            <button class="bg-gray-800 p-3 rounded-lg text-white" wire:click="remove_tutor({{$tutor->id}})">Remover</button>
                        </div>
                    @endforeach
                @else
                    <p class="text-xs">No tienes tutores asignados a este curso.</p>                    
                @endif
            </div>
            <div class="border-2 border-gray-200 rounded-md p-1">
                <p class="text-xl">Tutores disponibles</p>
                @if (count($tutors_disp)>0)
                    @foreach ($tutors_disp as $tutor)
                        <div class="flex w-full justify-between p-3 items-center">
                            <p>{{$tutor->name}}</p>
                            <button class="bg-gray-800 p-3 rounded-lg text-white" wire:click="asign_tutor({{$tutor->id}})">Asignar</button>
                        </div>
                    @endforeach
                @else
                    <p class="text-xs">No tienes tutores disponibles para este curso.</p>                    
                @endif
            </div>
        </div>
        <button class="bg-gray-800 text-white p-3 rounded-lg absolute top-0 right-0 m-3" wire:click="cancel" @click="open=false">Cerrar</button>    
    </div>
</div>
