<form method="POST" action="{{ route('login') }}">
    @csrf
    <a href="{{ url('auth/google') }}" style="margin-top: 0px !important;background: green;color: #ffffff;padding: 5px;border-radius:7px;" class="ml-2">
        <strong>Google Login</strong>
      </a>
</form>