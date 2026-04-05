<x-guest-layout>

    <div style="min-height:100vh; display:flex; align-items:center; justify-content:center; background:#f1f5f9;">

        <div style="width:100%; max-width:400px; background:white; padding:30px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.1);">

            <!-- 🔥 TITLE -->
            <h2 style="text-align:center; font-size:22px; font-weight:bold; margin-bottom:20px;">
                Login RFID Laundry
            </h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div>
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        style="width:100%; padding:10px; margin-top:5px; border:1px solid #ccc; border-radius:8px;"
                        required autofocus>
                </div>

                <!-- Password -->
                <div style="margin-top:15px;">
                    <label>Password</label>
                    <input type="password" name="password"
                        style="width:100%; padding:10px; margin-top:5px; border:1px solid #ccc; border-radius:8px;"
                        required>
                </div>

                <!-- Remember -->
                <div style="margin-top:10px;">
                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                </div>

                <!-- Button -->
                <button type="submit"
                    style="width:100%; margin-top:20px; padding:12px; background:#4f46e5; color:white; border:none; border-radius:8px; font-weight:bold;">
                    Login
                </button>

                <!-- Link -->
                <!-- Register dimatikan -->
                <div style="text-align:center; margin-top:15px; color:#999;">
                    Hubungi Admin untuk mendapatkan akun
                </div>

            </form>

        </div>

    </div>

</x-guest-layout>