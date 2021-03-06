<div class="w-full my-3" x-data="{open:false}">
    <div x-show="open" class="fixed inset-0 w-full h-screen bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg flex flex-col p-3 divide-y divide-gray-300">
            @foreach ($course->model->dimensions as $dim)
                <p class="p-3 cursor-pointer hover:bg-gray-300 text-gray-800" @click="open=false" wire:click="create({{$dim->id}})">{{$dim->name}}</p>
            @endforeach
            <p @click="open=false" class=" p-3 text-red-600 font-bold cursor-pointer">Cancelar</p>
        </div>
    </div>
    <div class="flex w-full gap-1">
        <div class="flex flex-col flex-1 gap-1">
            <p style="background-color: {{$course->color}}" class="w-full h-8  text-white font-bold flex items-center justify-center">Hora</p>
            @for($h = 6; $h < 18; $h++ )
                <p class="w-full h-8  text-xs flex items-center justify-center text-white opacity-75" style="background-color: {{$course->color}}">{{$h}}</p>
            @endfor
        </div>
        @for ($i = 1; $i < 7; $i++)
            <div class="flex flex-col flex-1 gap-1" wire:click="$set('day',{{$i}})">
                @switch($i)
                    @case(1)
                        <p style="background-color: {{$course->color}}" class="w-full h-8 text-white flex items-center justify-center">{{__('Monday')}}</p>
                        @break
                    @case(2)
                        <p style="background-color: {{$course->color}}" class="w-full h-8 text-white flex items-center justify-center">{{__('Tuesday')}}</p>
                        @break
                    @case(3)
                        <p style="background-color: {{$course->color}}" class="w-full h-8 text-white flex items-center justify-center">{{__('Wednesday')}}</p>
                        @break
                    @case(4)
                        <p style="background-color: {{$course->color}}" class="w-full h-8 text-white flex items-center justify-center">{{__('Thursday')}}</p>
                        @break
                    @case(5)
                        <p style="background-color: {{$course->color}}" class="w-full h-8 text-white flex items-center justify-center">{{__('Friday')}}</p>
                        @break
                    @case(6)
                        <p style="background-color: {{$course->color}}" class="w-full h-8 text-white flex items-center justify-center">{{__('Saturday')}}</p>
                        @break
                        
                @endswitch
                @for($h = 6; $h < 18; $h++ )
                    @if (count($course->schedule()->where(['day'=>$i,'start'=>$h])->get()) == 0)
                        <div style="background-color: {{$course->color}}" class=" bg-green-100 text-xs w-full h-8 opacity-50 hover:text-white">
                            <div @click="open=true" wire:click="$set('start','{{$h}}')" class="w-full text-white h-8  flex items-center justify-center text-xs cursor-pointer">
                            </div>
                            {{--  @php
                            $count = 0;
                            @endphp  --}}
                            {{--  @foreach ($schedule as $item)
                                @if ($item->day == $i && $item->start == $h)
                                    <div style="background-color: {{$item->courses[0]->color}}" class="w-full h-8 cursor-pointer flex items-center justify-center text-white" wire:click="$emitTo('course.show.admin','show_stripe',{{$item->id}})">
                                        

                                    </div>
                                    @php
                                        $count = 1;
                                    @endphp
                                @endif
                            @endforeach  --}}
                        </div>
                    @else
                        <div wire:click="$emitTo('course.show.admin','show_stripe',{{$course->schedule()->where(['day'=>$i,'start'=>$h])->first()->id}})" style="background-color: {{$course->color}}" class="w-full h-8 cursor-pointer flex items-center justify-center text-white p-1 rounded-sm">
                            <p class="text-xs">
                                @switch($course->schedule()->where(['day'=>$i,'start'=>$h])->first()->dimension)
                                    @case(1)  Corporal @break                                                
                                    @case(2)  Cognitiva @break                                                
                                    @case(3)  Comunicativa @break
                                    @case(4)  Etica @break
                                    @case(5)  Estetica @break
                                    @case(6)  Actitudinal @break
                                    @case(7)  Valorativa @break
                                    @case(8)  Matemáticas @break
                                    @case(9)  Humanidades @break
                                    @case(10) Ciencias Naturales @break
                                    @case(11) Ciencias Sociales @break
                                    @case(12) Educación Artística @break
                                    @case(13) Educación Etica @break
                                    @case(14) Educación Fisica @break
                                    @case(15) Educación Religiosa @break
                                    @case(16) Tecnologia e informatica @break
                                    @case(17) Ciencias Politicas @break
                                    @case(18) Filosofia @break
                                @endswitch
                            </p>
                        </div>                        
                    @endif
                @endfor
            </div>
        @endfor
    </div>
</div>
