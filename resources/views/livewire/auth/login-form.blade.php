<div class="min-h-dvh bg-gray-100">
	<main class="min-h-dvh lg:grid lg:grid-cols-5">
		<aside class="bg-gym-hero hidden lg:col-span-3 lg:block" aria-label="Presentación de la plataforma">
			<div class="flex h-full flex-col justify-between p-10 text-white xl:p-14">
				<header class="flex w-fit items-center gap-4 border-2 border-white/35 bg-slate-900/60 px-4 py-3 shadow-brutal-sm">
					<h1 class="text-gym-blue text-6xl font-black uppercase leading-none">GYMADM</h1>
					<x-icons.dumbbell-lifting class="h-11 w-11 text-white" />
				</header>

				<section class="max-w-2xl">
					<h2 class="text-5xl font-black leading-tight xl:text-6xl">La mejor forma de administrar tu gimnasio.</h2>
					<p class="mt-6 max-w-xl text-3xl leading-relaxed text-gray-300">
						Gestiona membresías, pagos, horarios y más desde una sola plataforma.
					</p>
				</section>

				<section class="grid grid-cols-3 gap-5" aria-label="Indicadores de la plataforma">
					<article class="border-2 border-white/30 bg-slate-900/55 p-6">
						<p class="text-gym-blue text-5xl font-black leading-none">500+</p>
						<p class="mt-3 text-2xl font-bold uppercase tracking-wide text-slate-300">Gimnasios activos</p>
					</article>
					<article class="border-2 border-white/30 bg-slate-900/55 p-6">
						<p class="text-gym-blue text-5xl font-black leading-none">50K+</p>
						<p class="mt-3 text-2xl font-bold uppercase tracking-wide text-slate-300">Miembros gestionados</p>
					</article>
					<article class="border-2 border-white/30 bg-slate-900/55 p-6">
						<p class="text-gym-blue text-5xl font-black leading-none">99.9%</p>
						<p class="mt-3 text-2xl font-bold uppercase tracking-wide text-slate-300">Uptime garantizado</p>
					</article>
				</section>
			</div>
		</aside>

		<section class="flex min-h-dvh items-center justify-center px-4 py-8 lg:col-span-2 lg:bg-gray-200" aria-label="Formulario de inicio de sesión">
			<div class="w-full max-w-xl border-2 border-black bg-gray-100 p-6 shadow-brutal lg:max-w-lg lg:border-0 lg:bg-transparent lg:shadow-none">
				<header class="mb-8">
					<h2 class="text-5xl font-black leading-tight text-gray-900">Iniciar sesión</h2>
					<p class="mt-3 border-t-4 border-gym-blue pt-4 text-2xl text-gray-600">Ingresa tus credenciales para acceder</p>
				</header>

				<form wire:submit.prevent="logIn" class="flex flex-col gap-5" novalidate>
					<div class="flex flex-col gap-2">
						<label for="email" class="text-xl font-black uppercase tracking-wide text-gray-900">Usuario o correo</label>
						<input
							id="email"
							type="email"
							wire:model.defer="email"
							class="w-full border-2 border-black bg-white px-4 py-3 text-xl text-gray-900 placeholder:text-gray-400 focus:outline-none focus:shadow-blue-gym"
							autocomplete="email"
							placeholder="ejemplo@correo.com"
							required
						>
						@error('email')
							<p class="text-sm font-bold text-red-600">{{ $message }}</p>
						@enderror
					</div>

					<div class="flex flex-col gap-2">
						<label for="password" class="text-xl font-black uppercase tracking-wide text-gray-900">Contraseña</label>
						<input
							id="password"
							type="password"
							wire:model.defer="password"
							class="w-full border-2 border-black bg-white px-4 py-3 text-xl text-gray-900 placeholder:text-gray-400 focus:outline-none focus:shadow-blue-gym"
							autocomplete="current-password"
							placeholder="••••••••"
							required
						>
						@error('password')
							<p class="text-sm font-bold text-red-600">{{ $message }}</p>
						@enderror
					</div>

					<a href="{{route('recovery-account')}}" class="ml-auto w-fit border-b-2 border-gray-900 text-xl font-bold uppercase text-gray-900">¿Olvidaste tu contraseña?</a>

					<button
						type="submit"
						class="w-full cursor-pointer border-2 border-black bg-gym-blue px-4 py-4 text-4xl font-black uppercase text-white shadow-brutal transition hover:translate-x-1 hover:translate-y-1 hover:shadow-none disabled:cursor-not-allowed disabled:opacity-80"
						wire:loading.attr="disabled"
						wire:target="logIn"
					>
						<span wire:loading.remove wire:target="logIn">Iniciar sesión</span>
						<span wire:loading wire:target="logIn">Validando...</span>
					</button>
				</form>

				<footer class="mt-7 border-t border-gray-300 pt-6 text-center text-2xl text-gray-600">
					<p>
						¿No tienes una cuenta?
						<a href="{{ route('register') }}" class="font-black text-gray-900 underline decoration-2">Regístrate aquí</a>
					</p>
				</footer>
			</div>
		</section>
	</main>
</div>
