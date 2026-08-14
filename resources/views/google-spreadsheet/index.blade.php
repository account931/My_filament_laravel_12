<!-- Read Google spreadsheet. Spreadsheet itself collects answers from Google form-->
<!-- Advanced design with AI, see simple version in indexSimpleDesign.blade.php -->
<x-app-layout>

    {{-- Header Slot --}}
    <x-slot name="header">
        <div class="google-page-header">
            <div>
                <h2 class="google-page-title">
                    <i class="fas fa-table"></i>
                    {{ __('Read Google spreadsheet. Spreadsheet itself collects answers from Google form') }}
                </h2>
                <p class="google-page-subtitle">
                    Google Sheets integration and spreadsheet data reader
                </p>
            </div>
        </div>
    </x-slot>

    {{-- Styles Slot (optional extra CSS/JS) --}}
    <x-slot name="styles">
        <!-- Bootstrap Select JS -->
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>-->
    </x-slot>

    {{-- Page Content --}}
    <div class="container google-page-container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card google-main-card">

                    <div class="card-header google-card-header">
                        <div class="google-header-icon">
                            <i class="fab fa-google"></i>
                        </div>

                        <div>
                            <div class="google-header-title">
                                Read Google Spreadsheet
                            </div>

                            <div class="google-header-description">
                                Spreadsheet itself collects answers from Google form.
                                Located at di***1.
                            </div>

                            <div class="google-header-meta">
                                <span>
                                    <i class="fas fa-sign-in-alt"></i>
                                    Uses Socialite login
                                </span>

                                <span>
                                    <i class="fas fa-project-diagram"></i>
                                    Google console project: <strong>Laravel DB Backup</strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body google-card-body">

                        {{-- Session status --}}
                        @if (session('status'))
                            <div class="alert alert-success google-alert google-alert-success" role="alert">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ session('status') }}</span>
                            </div>
                        @endif

                        <div class="alert alert-success google-user-panel">

                            <div class="row">

                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    {{-- Placeholder for additional content --}}
                                </div>

                                {{-- Flash messages --}}
                                @if (session()->has('flashSuccess'))
                                    <div class="row alert alert-success google-alert google-alert-success">
                                        <i class="fas fa-charging-station"></i>
                                        <span>{{ session('flashSuccess') }}</span>
                                    </div>
                                @endif

                                @if (session()->has('flashFailure'))
                                    <div class="row alert alert-danger google-alert google-alert-danger">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <span>{{ session('flashFailure') }}</span>
                                    </div>
                                @endif

                            </div>

                            <div class="col-sm-12 col-xs-12">

                                {{-- Display validation errors --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger google-alert google-alert-danger">
                                        <div class="google-alert-title">
                                            <i class="fas fa-exclamation-circle"></i>
                                            Please correct the following errors:
                                        </div>

                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="g-spreadsheet-row">

                                    <!------------ Read Google spreadsheet flow . Spreadsheet itself collects answers from Google form- --------->

                                    <!-- Show when user is logged to Google via Socialite -->
                                    @if (Auth::user()->google_refresh_token AND session('google_oauthed_user')) <!-- session('google_oauthed_user' is fix to work with Socialite login -->

                                        <div class="google-connected-panel">

                                            <div class="google-status-banner google-status-connected">
                                                <div class="google-status-icon">
                                                    <i class="fas fa-check"></i>
                                                </div>

                                                <div>
                                                    <div class="google-status-title">
                                                        Google account connected
                                                    </div>

                                                    <div class="google-status-description">
                                                        User has google_refresh_token
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Button to read spreadsheet -->
                                            <div class="google-action-card">

                                                <div class="google-action-icon google-action-icon-blue">
                                                    <i class="fas fa-file-excel"></i>
                                                </div>

                                                <div class="google-action-content">
                                                    <div class="google-action-title">
                                                        Load Google Spreadsheet
                                                    </div>

                                                    <div class="google-action-description">
                                                        Read the latest available data from the connected Google spreadsheet.
                                                    </div>
                                                </div>

                                                <form method="POST" action="{{ route('google.spreadsheet.index') }}">
                                                    @csrf
                                                    <button type="submit" class="google-btn google-btn-primary">
                                                        <i class="fas fa-file-excel"></i>
                                                        Load Spreadsheet
                                                    </button>
                                                </form>

                                            </div>


                                            <!-- Log out Socialite Google form -->
                                            <div class="google-logout-card">

                                                <div>
                                                    <div class="google-action-title">
                                                        Google authentication
                                                    </div>

                                                    <div class="google-action-description">
                                                        Disconnect the current Google authentication session.
                                                    </div>
                                                </div>

                                                <form action="{{ url('/auth/google/logout') }}" method="GET">
                                                    <button type="submit" class="google-btn google-btn-danger">
                                                        <i class="fa fa-sign-out-alt"></i>
                                                        Log Out of Google
                                                    </button>
                                                </form>

                                            </div>

                                            <br>
                                            <!-- End Log out Socialite Google form -->


                                            <!-- if there are data from spreadsheet -->
                                            @if (count($values))

                                                <div class="google-table-wrapper">

                                                    <div class="google-table-header">
                                                        <div>
                                                            <i class="fas fa-table"></i>
                                                            Spreadsheet Data
                                                        </div>

                                                        <div class="google-table-count">
                                                            {{ count($values) }} rows
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered google-spreadsheet-table">

                                                            @foreach ($values as $row)
                                                                <tr>
                                                                    @foreach ($row as $cell)
                                                                        <td>{{ $cell }}</td>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach

                                                        </table>
                                                    </div>

                                                </div>

                                            @else

                                                <div class="google-empty-state">
                                                    <div class="google-empty-icon">
                                                        <i class="fas fa-inbox"></i>
                                                    </div>

                                                    <div class="google-empty-title">
                                                        No data found
                                                    </div>

                                                    <div class="google-empty-description">
                                                        The spreadsheet did not return any data.
                                                    </div>
                                                </div>

                                            @endif

                                        </div>

                                    <!-- Show when user has NOT logged to Google via Socialite -->
                                    @else

                                        <div class="google-login-required">

                                            <div class="google-status-banner google-status-disconnected">

                                                <div class="google-status-icon">
                                                    <i class="fas fa-exclamation"></i>
                                                </div>

                                                <div>
                                                    <div class="google-status-title">
                                                        Google authentication required
                                                    </div>

                                                    <div class="google-status-description">
                                                        User does not have google_refresh_token.
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="google-login-content">

                                                <div class="google-login-icon">
                                                    <i class="fab fa-google"></i>
                                                </div>

                                                <div class="google-login-text">

                                                    <div class="google-login-title">
                                                        Connect your Google account
                                                    </div>

                                                    <div class="google-login-description">
                                                        First go to Socialite, log in with Google,
                                                        and then come back here manually.
                                                    </div>

                                                </div>

                                                <form action="{{ url('/auth/google') }}" method="GET">
                                                    <button type="submit" class="google-btn google-btn-google">
                                                        <i class="fab fa-google"></i>
                                                        Log in with Google
                                                        <i class="fas fa-arrow-right"></i>
                                                    </button>
                                                </form>

                                            </div>

                                        </div>

                                    @endif

                                </div>
                                {{-- End .g-spreadsheet-row --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>

    /* ============================================================
       Bright Google Spreadsheet Page
       ============================================================ */

    :root {
        --google-blue: #1a73e8;
        --google-blue-light: #e8f0fe;
        --google-blue-bright: #4285f4;
        --google-blue-dark: #0b57d0;

        --google-green: #1e8e3e;
        --google-green-light: #e6f4ea;
        --google-green-bright: #34a853;

        --google-red: #d93025;
        --google-red-light: #fce8e6;
        --google-red-bright: #ea4335;

        --google-yellow: #f9ab00;
        --google-yellow-light: #fef7e0;

        --page-background: #f4f8ff;
        --card-background: #ffffff;

        --text-primary: #172033;
        --text-secondary: #536174;
        --text-muted: #7b8798;

        --border-color: #dbe5f2;
        --border-light: #e9eff7;

        --shadow-small:
            0 3px 12px rgba(26, 115, 232, 0.08);

        --shadow-medium:
            0 10px 30px rgba(26, 115, 232, 0.12);

        --shadow-bright:
            0 5px 20px rgba(66, 133, 244, 0.18);

        --radius-small: 9px;
        --radius-medium: 14px;
        --radius-large: 20px;
    }


    /* ============================================================
       Main page
       ============================================================ */

    body {
        background:
            radial-gradient(
                circle at top right,
                rgba(66, 133, 244, 0.10),
                transparent 35%
            ),
            linear-gradient(
                180deg,
                #f7faff 0%,
                #f1f6ff 100%
            );
    }

    .google-page-container {
        padding-top: 35px;
        padding-bottom: 60px;
    }

    .google-page-header {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .google-page-title {
        margin: 0;

        color: var(--text-primary);

        font-size: 22px;
        font-weight: 700;
        letter-spacing: -0.2px;
    }

    .google-page-title i {
        color: var(--google-blue);
        margin-right: 8px;
    }

    .google-page-subtitle {
        margin: 6px 0 0;

        color: var(--text-secondary);

        font-size: 13px;
    }


    /* ============================================================
       Main card
       ============================================================ */

    .google-main-card {
        border: 1px solid #dce8f8;
        border-radius: var(--radius-large);

        background:
            linear-gradient(
                145deg,
                #ffffff 0%,
                #fbfdff 100%
            );

        box-shadow: var(--shadow-medium);

        overflow: hidden;
    }


    /* ============================================================
       Header
       ============================================================ */

    .google-card-header {
        position: relative;

        display: flex;
        align-items: center;
        gap: 18px;

        padding: 28px 32px;

        background:
            linear-gradient(
                135deg,
                #ffffff 0%,
                #f2f7ff 55%,
                #eef5ff 100%
            );

        border-bottom: 1px solid #dce8f8;
    }

    .google-card-header::after {
        content: "";

        position: absolute;

        left: 0;
        right: 0;
        bottom: 0;

        height: 3px;

        background:
            linear-gradient(
                90deg,
                #4285f4 0%,
                #34a853 35%,
                #fbbc05 65%,
                #ea4335 100%
            );
    }

    .google-header-icon {
        width: 58px;
        height: 58px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 16px;

        background:
            linear-gradient(
                135deg,
                #e8f0fe,
                #d7e7ff
            );

        color: var(--google-blue);

        font-size: 29px;

        flex-shrink: 0;

        box-shadow:
            0 5px 15px rgba(66, 133, 244, 0.15);
    }

    .google-header-title {
        color: var(--text-primary);

        font-size: 21px;
        font-weight: 700;
    }

    .google-header-description {
        margin-top: 5px;

        color: var(--text-secondary);

        font-size: 14px;
    }

    .google-header-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;

        margin-top: 11px;

        color: var(--text-muted);

        font-size: 12px;
    }

    .google-header-meta i {
        color: var(--google-blue);
        margin-right: 5px;
    }


    /* ============================================================
       Card body
       ============================================================ */

    .google-card-body {
        padding: 32px;
    }


    /* ============================================================
       Alerts
       ============================================================ */

    .google-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;

        border-radius: var(--radius-small);

        padding: 15px 18px;

        box-shadow: var(--shadow-small);
    }

    .google-alert > i {
        margin-top: 2px;
    }

    .google-alert-success {
        color: #137333;

        background:
            linear-gradient(
                135deg,
                #f0fff4,
                #e6f8eb
            );

        border: 1px solid #b7dfc2;
        border-left: 5px solid var(--google-green-bright);
    }

    .google-alert-danger {
        color: #b3261e;

        background:
            linear-gradient(
                135deg,
                #fff8f7,
                #fcebea
            );

        border: 1px solid #f1c5c1;
        border-left: 5px solid var(--google-red-bright);
    }

    .google-alert-title {
        font-weight: 700;
        margin-bottom: 7px;
    }


    /* ============================================================
       User panel
       ============================================================ */

    .google-user-panel {
        padding: 22px;

        background:
            linear-gradient(
                135deg,
                #ffffff 0%,
                #f5f9ff 100%
            );

        border: 1px solid #d8e6f8;
        border-radius: var(--radius-medium);

        color: var(--text-primary);

        box-shadow: var(--shadow-small);
    }

    .google-user-heading {
        display: flex;
        align-items: center;
        gap: 13px;

        margin-bottom: 25px;
    }

    .google-user-icon {
        width: 48px;
        height: 48px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background:
            linear-gradient(
                135deg,
                #e8f0fe,
                #d7e7ff
            );

        color: var(--google-blue);

        font-size: 19px;

        box-shadow:
            0 4px 12px rgba(66, 133, 244, 0.12);
    }

    .google-user-label {
        color: var(--text-muted);

        font-size: 11px;
        font-weight: 600;

        text-transform: uppercase;
        letter-spacing: .7px;
    }

    .google-user-name {
        margin-top: 2px;

        color: var(--text-primary);

        font-size: 18px;
        font-weight: 700;
    }


    /* ============================================================
       Connected panel
       ============================================================ */

    .google-connected-panel {
        margin-top: 20px;
        padding: 22px;

        background:
            linear-gradient(
                145deg,
                #ffffff,
                #fbfdff
            );

        border: 1px solid #d7e4f4;
        border-radius: var(--radius-medium);

        box-shadow: var(--shadow-small);
    }


    /* ============================================================
       Status banner
       ============================================================ */

    .google-status-banner {
        display: flex;
        align-items: center;
        gap: 14px;

        padding: 16px 18px;

        border-radius: var(--radius-small);
    }

    .google-status-connected {
        background:
            linear-gradient(
                135deg,
                #effcf3,
                #e5f7ea
            );

        color: #137333;

        border: 1px solid #b8e0c3;

        box-shadow:
            0 3px 10px rgba(52, 168, 83, 0.08);
    }

    .google-status-disconnected {
        background:
            linear-gradient(
                135deg,
                #fff9f8,
                #fcebea
            );

        color: #b3261e;

        border: 1px solid #efc8c4;
    }

    .google-status-icon {
        width: 37px;
        height: 37px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background: #ffffff;

        box-shadow:
            0 2px 8px rgba(0, 0, 0, 0.08);

        flex-shrink: 0;
    }

    .google-status-title {
        font-weight: 700;
        font-size: 15px;
    }

    .google-status-description {
        margin-top: 3px;

        font-size: 12px;

        opacity: .8;
    }


    /* ============================================================
       Action cards
       ============================================================ */

    .google-action-card {
        display: flex;
        align-items: center;
        gap: 16px;

        margin-top: 18px;
        padding: 20px;

        background:
            linear-gradient(
                135deg,
                #ffffff,
                #f8fbff
            );

        border: 1px solid #dce7f5;
        border-radius: var(--radius-medium);

        box-shadow: 0 2px 8px rgba(26, 115, 232, 0.04);

        transition:
            transform .2s ease,
            box-shadow .2s ease,
            border-color .2s ease;
    }

    .google-action-card:hover {
        transform: translateY(-2px);

        border-color: #b9d0f2;

        box-shadow: var(--shadow-bright);
    }

    .google-action-icon {
        width: 50px;
        height: 50px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        font-size: 21px;

        flex-shrink: 0;
    }

    .google-action-icon-blue {
        background:
            linear-gradient(
                135deg,
                #e8f0fe,
                #d7e7ff
            );

        color: var(--google-blue);

        box-shadow:
            0 4px 10px rgba(66, 133, 244, 0.12);
    }

    .google-action-content {
        flex: 1;
    }

    .google-action-title {
        color: var(--text-primary);

        font-size: 14px;
        font-weight: 700;
    }

    .google-action-description {
        margin-top: 4px;

        color: var(--text-secondary);

        font-size: 12px;
        line-height: 1.55;
    }


    /* ============================================================
       Buttons
       ============================================================ */

    .google-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        border-radius: 9px;

        padding: 11px 18px;

        font-size: 13px;
        font-weight: 700;

        cursor: pointer;

        transition:
            transform .15s ease,
            box-shadow .2s ease,
            background .2s ease;
    }

    .google-btn:hover {
        transform: translateY(-2px);
    }

    .google-btn-primary {
        background:
            linear-gradient(
                135deg,
                #4285f4,
                #1a73e8
            );

        color: #ffffff;

        border: 0;

        box-shadow:
            0 5px 14px rgba(26, 115, 232, 0.25);
    }

    .google-btn-primary:hover {
        background:
            linear-gradient(
                135deg,
                #1a73e8,
                #0b57d0
            );

        color: #ffffff;

        box-shadow:
            0 7px 18px rgba(26, 115, 232, 0.32);
    }

    .google-btn-danger {
        background: #ffffff;

        color: var(--google-red);

        border: 1px solid #efc4c0;

        box-shadow:
            0 2px 6px rgba(217, 48, 37, 0.06);
    }

    .google-btn-danger:hover {
        background: #fff6f5;

        color: #b3261e;

        border-color: #e8aaa5;
    }

    .google-btn-google {
        background: #ffffff;

        color: var(--text-primary);

        border: 1px solid #cfd8e3;

        box-shadow:
            0 3px 10px rgba(32, 33, 36, .08);
    }

    .google-btn-google:hover {
        background: #f8fbff;

        color: var(--text-primary);

        border-color: #a9c5e8;

        box-shadow:
            0 6px 16px rgba(66, 133, 244, .15);
    }

    .google-btn-google .fa-google {
        color: var(--google-blue);
    }


    /* ============================================================
       Logout
       ============================================================ */

    .google-logout-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;

        margin-top: 14px;
        padding: 17px 19px;

        background:
            linear-gradient(
                135deg,
                #ffffff,
                #fffdfd
            );

        border: 1px solid #e7e8eb;
        border-radius: var(--radius-medium);

        box-shadow:
            0 2px 7px rgba(0, 0, 0, .03);
    }


    /* ============================================================
       Spreadsheet table
       ============================================================ */

    .google-table-wrapper {
        margin-top: 27px;

        border: 1px solid #d6e2f0;
        border-radius: var(--radius-medium);

        overflow: hidden;

        background: #ffffff;

        box-shadow: var(--shadow-medium);
    }

    .google-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        padding: 17px 19px;

        background:
            linear-gradient(
                135deg,
                #edf5ff,
                #f7fbff
            );

        border-bottom: 1px solid #d7e4f4;

        color: var(--text-primary);

        font-size: 14px;
        font-weight: 700;
    }

    .google-table-header i {
        color: var(--google-blue);
        margin-right: 7px;
    }

    .google-table-count {
        padding: 4px 9px;

        border-radius: 20px;

        background: #e8f0fe;

        color: var(--google-blue);

        font-size: 11px;
        font-weight: 700;
    }

    .google-spreadsheet-table {
        margin: 0;

        background: #ffffff;

        font-size: 13px;
    }

    .google-spreadsheet-table td {
        padding: 12px 15px;

        color: #344054;

        background: #ffffff;

        border-color: #e5ebf3 !important;

        vertical-align: middle;

        white-space: nowrap;
    }

    .google-spreadsheet-table tr:first-child td {
        background:
            linear-gradient(
                135deg,
                #edf5ff,
                #f5f9ff
            );

        color: #172033;

        font-weight: 700;

        border-top: 0 !important;
    }

    .google-spreadsheet-table tr:nth-child(even) td {
        background: #fbfdff;
    }

    .google-spreadsheet-table tr:hover td {
        background: #eef6ff;
    }


    /* ============================================================
       Empty state
       ============================================================ */

    .google-empty-state {
        margin-top: 27px;
        padding: 50px 25px;

        text-align: center;

        background:
            linear-gradient(
                135deg,
                #f8fbff,
                #eef6ff
            );

        border: 1px dashed #b8cbe3;
        border-radius: var(--radius-medium);
    }

    .google-empty-icon {
        width: 60px;
        height: 60px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin: 0 auto 14px;

        border-radius: 50%;

        background:
            linear-gradient(
                135deg,
                #e8f0fe,
                #d7e7ff
            );

        color: var(--google-blue);

        font-size: 24px;

        box-shadow:
            0 5px 15px rgba(66, 133, 244, .12);
    }

    .google-empty-title {
        color: var(--text-primary);

        font-size: 17px;
        font-weight: 700;
    }

    .google-empty-description {
        margin-top: 6px;

        color: var(--text-secondary);

        font-size: 13px;
    }


    /* ============================================================
       Google login required
       ============================================================ */

    .google-login-required {
        margin-top: 20px;

        background: #ffffff;

        border: 1px solid #f0d1cd;
        border-radius: var(--radius-medium);

        overflow: hidden;

        box-shadow: var(--shadow-small);
    }

    .google-login-content {
        display: flex;
        align-items: center;
        gap: 18px;

        padding: 24px;

        background:
            linear-gradient(
                135deg,
                #ffffff,
                #fffafa
            );
    }

    .google-login-icon {
        width: 55px;
        height: 55px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #ffffff,
                #f1f5f9
            );

        font-size: 25px;

        box-shadow:
            0 4px 12px rgba(0, 0, 0, .06);
    }

    .google-login-icon .fa-google {
        color: var(--google-blue);
    }

    .google-login-text {
        flex: 1;
    }

    .google-login-title {
        color: var(--text-primary);

        font-size: 16px;
        font-weight: 700;
    }

    .google-login-description {
        margin-top: 5px;

        color: var(--text-secondary);

        font-size: 12px;
        line-height: 1.6;
    }


    /* ============================================================
       Responsive
       ============================================================ */

    @media (max-width: 767px) {

        .google-page-container {
            padding: 15px 10px 35px;
        }

        .google-card-header {
            padding: 22px 20px;
            align-items: flex-start;
        }

        .google-header-title {
            font-size: 18px;
        }

        .google-header-meta {
            flex-direction: column;
            gap: 6px;
        }

        .google-card-body {
            padding: 16px;
        }

        .google-user-panel {
            padding: 16px;
        }

        .google-connected-panel {
            padding: 16px;
        }

        .google-action-card {
            flex-direction: column;
            align-items: stretch;
        }

        .google-action-card .google-action-icon {
            margin-bottom: 2px;
        }

        .google-action-card form {
            width: 100%;
        }

        .google-action-card .google-btn {
            width: 100%;
        }

        .google-logout-card {
            flex-direction: column;
            align-items: stretch;
        }

        .google-logout-card form {
            width: 100%;
        }

        .google-logout-card .google-btn {
            width: 100%;
        }

        .google-login-content {
            flex-direction: column;
            align-items: stretch;
            text-align: center;
        }

        .google-login-icon {
            margin: 0 auto;
        }

        .google-login-content form {
            width: 100%;
        }

        .google-login-content .google-btn {
            width: 100%;
        }

        .google-status-banner {
            align-items: flex-start;
        }

    }


    

</style>

</x-app-layout>