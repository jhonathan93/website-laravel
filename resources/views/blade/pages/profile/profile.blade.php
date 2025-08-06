@extends('blade.pages.home.home', ['profile' => 'Perfil Jhonathan'])

@section('main')
    <div class="min-h-screen bg-gray-50">
        <div class="h-48 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 lg:h-60"></div>

        <div class="max-w-5xl px-4 mx-auto -mt-24 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center pb-6 bg-white rounded-lg shadow-lg md:flex-row">
                <livewire:avatar/>

                <div class="px-6 mt-4 text-center md:text-left md:mt-0">
                    <div class="mt-4 flex flex-col items-center md:flex-row">
                        <h1 class="text-2xl font-bold text-gray-800">{{ Auth::user()->name }}</h1>
                    </div>

                    <div class="mt-2 flex flex-col items-center md:flex-row md:items-center md:justify-start">
                        <p class="text-gray-600">{{ Auth::user()->email }}</p>

                        <span
                            class="mt-2 md:mt-0 md:ml-4 px-3 py-1 text-sm text-green-800 bg-green-100 rounded-full flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                      clip-rule="evenodd"/>
                            </svg>
                            Verificado
                        </span>
                    </div>

                    <div class="flex justify-center mt-6 space-x-8 md:justify-start">
                        <div class="text-center">
                            <p class="text-xl font-bold">{{ Auth::user()->formattedDateOfBirth }}</p>
                            <p class="text-gray-500">Aniversário</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xl font-bold">{{ Auth::user()->age }}</p>
                            <p class="text-gray-500">Idade</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xl font-bold">{{ Auth::user()->formattedCpf }}</p>
                            <p class="text-gray-500">CPF</p>
                        </div>
                    </div>
                </div>

                <!-- Botão de ação -->
                <div class="mt-6 mb-4 ml-auto mr-6">
                    <button
                        class="px-6 py-2 font-semibold text-white transition-all duration-300 bg-purple-600 rounded-full hover:bg-purple-700 hover:shadow-lg">
                        Seguir
                    </button>
                </div>
            </div>

            <livewire:addresses />

            <!-- Últimos projetos -->
            <div class="p-6 mt-8 bg-white rounded-lg shadow">
                <h3 class="text-lg font-bold text-gray-800">Projetos Recentes</h3>
                <div class="grid grid-cols-1 gap-6 mt-4 md:grid-cols-2">
                    <!-- Projeto 1 -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="bg-gray-200 border-2 border-dashed rounded-lg w-14 h-14"></div>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800">Sistema de Dashboard</h4>
                            <p class="mt-1 text-gray-600">Painel administrativo com métricas em tempo real</p>
                            <div class="flex mt-2">
                                <span class="px-2 py-1 text-xs text-purple-800 bg-purple-100 rounded-full">Vue.js</span>
                                <span
                                    class="px-2 py-1 ml-2 text-xs text-purple-800 bg-purple-100 rounded-full">Laravel</span>
                            </div>
                        </div>
                    </div>

                    <!-- Projeto 2 -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="bg-gray-200 border-2 border-dashed rounded-lg w-14 h-14"></div>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800">Aplicativo Mobile</h4>
                            <p class="mt-1 text-gray-600">App de delivery com integração de pagamentos</p>
                            <div class="flex mt-2">
                                <span
                                    class="px-2 py-1 text-xs text-purple-800 bg-purple-100 rounded-full">React Native</span>
                                <span
                                    class="px-2 py-1 ml-2 text-xs text-purple-800 bg-purple-100 rounded-full">Node.js</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
