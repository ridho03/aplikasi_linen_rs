<x-guest-layout>

    <div style="
        min-height:100vh;
        display:flex;
        align-items:center;
        justify-content:center;
        background:linear-gradient(135deg, #0f172a, #1e293b);
    ">

        <div style="
            width:100%;
            max-width:400px;
            background:#1e293b;
            padding:30px;
            border-radius:16px;
            box-shadow:0 10px 30px rgba(0,0,0,0.5);
            color:white;
        ">

            <!-- 🔥 TITLE -->
            <h2 style="
                text-align:center;
                font-size:22px;
                font-weight:bold;
                margin-bottom:20px;
                color:#e2e8f0;
            ">
                Login RFID Laundry
            </h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div>
                    <label style="color:#cbd5f5;">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        style="
                            width:100%;
                            padding:10px;
                            margin-top:5px;
                            background:#0f172a;
                            border:1px solid #334155;
                            border-radius:8px;
                            color:white;
                        "
                        required autofocus>
                </div>

                <!-- Password -->
                <div style="margin-top:15px;">
                    <label style="color:#cbd5f5;">Password</label>
                    <input type="password" name="password"
                        style="
                            width:100%;
                            padding:10px;
                            margin-top:5px;
                            background:#0f172a;
                            border:1px solid #334155;
                            border-radius:8px;
                            color:white;
                        "
                        required>
                </div>

                <!-- Remember -->
                <div style="margin-top:10px; color:#94a3b8;">
                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                </div>

                <!-- Button -->
                <button type="submit"
                    style="
                        width:100%;
                        margin-top:20px;
                        padding:12px;
                        background:linear-gradient(90deg,#6366f1,#4f46e5);
                        color:white;
                        border:none;
                        border-radius:8px;
                        font-weight:bold;
                        cursor:pointer;
                    ">
                    Login
                </button>

                <!-- Footer -->
                <div style="text-align:center; margin-top:15px; color:#64748b;">
                    Hubungi Admin untuk mendapatkan akun
                </div>

            </form>

        </div>

    </div>

</x-guest-layout>