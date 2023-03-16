@php
    /** @var \App\Configuration\BitPayConfiguration $configuration **/
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $configuration->getDesign()->getHero()->getTitle() }}</title>
    <link rel="stylesheet" href="/css/styles.css" type="text/css" media="all">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
</head>

<body>
<header class="bg-white shadow-sm lg:static lg:overflow-y-visible">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative flex justify-between xl:grid xl:grid-cols-12 lg:gap-8">
            <div class="flex md:absolute md:left-0 md:inset-y-0 lg:static xl:col-span-2">
                <div class="flex-shrink-0 flex items-center p-5">
                    <a href="#">
                        <img src="{{ $configuration->getDesign()->getLogo() }}" height="34" width="284">
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<div id="hero" class="relative" style="'background-color:' + {{ $configuration->getDesign()->getHero()->getBgColor() }}">
    <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl text-center">{{ $configuration->getDesign()->getHero()->getTitle() }}</h1>
        <p class="mt-6 text-xl text-white max-w-3xl text-center m-auto">{{ $configuration->getDesign()->getHero()->getBody() }}</p>
    </div>
</div>



<div class="m-auto mt-6 max-w-3xl">
    @if($errorMessage !== null)
        <div class="mt-4 bg-red-700">
            <span>{{ $errorMessage }}</span>
        </div>
    @endif


    <form action="{{ route('createInvoice', [], false) }}" method="post">
        @csrf
        @foreach($configuration->getDesign()->getPosData()->getFields() as $field)

            <div class="mt-4">

                @switch($field->getType())
                    @case('select')
                        <label for="{{ $field->getName() }}" class="block text-sm font-medium text-gray-700">{{ $field->getLabel() }}</label>
                        <select id="{{ $field->getId() }}" name="{{ $field->getName() }}" required="{{ $field->isRequired() }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option selected="selected" value=""></option>
                            @foreach($field->getOptions() as $option)
                                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                            @endforeach
                        </select>
                    @break

                    @case('fieldset')
                        <fieldset>
                            <legend>{{ $field->getLabel() }}</legend>
                            @foreach($field->getOptions() as $option)
                                <input type="radio" required="{{ $field->isRequired() }}" id="{{ $option['id'] }}"
                                       name="{{ $field->getName() }}" value="{{ $option['value'] }}" />
                                <label for="{{ $option['id'] }}">{{ $option['label'] }}</label>
                            @endforeach
                        </fieldset>
                    @break

                    @case('text')
                        <label for="{{ $field->getName() }}" class="block text-sm font-medium text-gray-700">{{ $field->getLabel() }}</label>
                        <div class="mt-1">
                            <input type="text" id="{{ $field->getId() }}" name="{{ $field->getName() }}" required="{{ $field->isRequired() }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                        </div>
                    @break

                    @case('price')
                        <label for="{{ $field->getName() }}" class="block text-sm font-medium text-gray-700">{{ $field->getLabel() }}</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm"> $ </span>
                            </div>
                            <input type="number"  id="{{ $field->getId() }}" name="{{ $field->getName() }}" required="{{ $field->isRequired() }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00" attr="aria-describedby={{ $field->getId() }}-currency" />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm" id="{{ $field->getId() }}-currency"> {{ $field->getCurrency() }} </span>
                            </div>
                        </div>
                    @break
                @endswitch
        @endforeach

                <div class="mt-4 text-center">
                    <button type="submit">
                        <img src="https://test.bitpay.com/cdn/en_US/bp-btn-pay-currencies.svg" />
                    </button>
                </div>

            </div>
    </form>
</div>
</body>

</html>
