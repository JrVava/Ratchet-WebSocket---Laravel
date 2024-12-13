@extends('layout.layout')

@section('content')
<main class="min-h-screen flex items-center justify-center bg-gray-100">
  <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
      <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h2>
      <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
          @csrf
          <!-- Email Field -->
          <div>
              <label for="email_address" class="block text-sm font-medium text-gray-700">E-Mail Address</label>
              <input 
                  type="text" 
                  id="email_address" 
                  name="email" 
                  class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                  required 
                  autofocus>
              @if ($errors->has('email'))
                  <p class="text-sm text-red-600 mt-2">{{ $errors->first('email') }}</p>
              @endif
          </div>

          <!-- Password Field -->
          <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              <input 
                  type="password" 
                  id="password" 
                  name="password" 
                  class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                  required>
              @if ($errors->has('password'))
                  <p class="text-sm text-red-600 mt-2">{{ $errors->first('password') }}</p>
              @endif
          </div>

          <!-- Remember Me Checkbox -->
          <div class="flex items-center">
              <input 
                  type="checkbox" 
                  name="remember" 
                  id="remember" 
                  class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
              <label for="remember" class="ml-2 block text-sm text-gray-700">Remember Me</label>
          </div>

          <!-- Submit Button -->
          <div>
              <button 
                  type="submit" 
                  class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                  Login
              </button>
          </div>
      </form>
  </div>
</main>
@endsection
