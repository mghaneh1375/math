 <nav>
    <div class="navbar">
        <div>
            <a href="{{ route('root') }}">خانه</a>
            <a href="{{ route('about') }}">درباره ما</a>
            <a href="/contactus">تماس با ما</a>
        </div>
        
        <div>
            <div class="search-box">
                <input type="search" placeholder="جستجو..." aria-label="جستجو">
            </div>
            
            @if(Auth::check())
              <div class="account-menu" id="accountMenu">
                  <button id="accountToggle" aria-expanded="false" aria-controls="accountPane">حساب من</button>
                  <div class="account-pane" id="accountPane" role="menu" aria-hidden="true">
                  @if(Auth::user()->level == \App\Enums\UserLevel::ADMIN->name)
                    <a href="{{route('admin_dashboard')}}" role="menuitem">پنل ادمین</a>
                  @else
                    <a href="#" role="menuitem">تراکنش‌های من</a>
                    <a href="{{ route('my_courses') }}" role="menuitem">دوره‌های من</a>
                  @endif
                  <a href="#" role="menuitem">تغییر رمزعبور</a>
                  <a href="{{ route('logout') }}" role="menuitem">خروج</a>
                  </div>
              </div>
            @else
              <a href="{{ route('login') }}" role="menuitem">ورود/ثبت‌نام</a>
            @endif
            <div class="logo">
              <img src="{{ asset('asset/img/logo.png') }}" width="40px" />
            </div>
        </div>
    </div>
</nav>

 <script>
    const accountToggle = document.getElementById('accountToggle');
    const accountMenu = document.getElementById('accountMenu');
    const accountPane = document.getElementById('accountPane');

    accountToggle.addEventListener('click', () => {
      const isOpen = accountMenu.classList.toggle('open');
      accountToggle.setAttribute('aria-expanded', isOpen);
      accountPane.setAttribute('aria-hidden', !isOpen);
    });

    // Close the account pane if clicked outside
    document.addEventListener('click', (event) => {
      if (!accountMenu.contains(event.target)) {
        accountMenu.classList.remove('open');
        accountToggle.setAttribute('aria-expanded', false);
        accountPane.setAttribute('aria-hidden', true);
      }
    });
</script>