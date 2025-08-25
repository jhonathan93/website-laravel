<div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-200">
    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-user-circle mr-2 text-blue-500"></i>
        Dados Pessoais
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo *</label>
            <input
                type="text"
                id="name"
                name="name"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Seu nome completo">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail *</label>
            <input
                type="email"
                id="email"
                name="email"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="seu@email.com">
        </div>

        <div>
            <label for="cpf" class="block text-sm font-medium text-gray-700 mb-1">CPF *</label>
            <input
                type="text"
                id="cpf"
                name="cpf"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="000.000.000-00">
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefone *</label>
            <input
                type="tel"
                id="phone"
                name="phone"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="(00) 00000-0000">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha *</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Mínimo de 8 caracteres">
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Senha *</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Digite novamente sua senha">
        </div>
    </div>
</div>
