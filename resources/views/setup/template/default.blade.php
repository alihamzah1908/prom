<html>

<head>
    @include('setup.template.partials.head')
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        @include('setup.template.partials.header')
        @yield('navbar')
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            @include('setup.template.partials.sidebar')
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background-color: rgb(255, 255, 255);">
            @yield('content')
        </div>
        @include('setup.template.partials.footer')
    </div>
    @include('modals')
    @include('setup.template.partials.scripts')
</body>

<script src="/js/theme.js?v=1"></script>

</html>



<!--
                              _.-'''.
                    _       .'       \
      ,..______  .-/\`--.../          \
      |        '\| \_`_-.  `.  _       \
     /        _ .' / /_`\`\  \/ '.      \
    /       /` /  /\_|_\/\ '._|   \      :
  .'       /  :   \ _  |  `\ .'__ |      | __,'\
  \        | __'. |/.`'----./ /| `'    .'''     '-.
   :      .`"\ `'\/ |`''--.'/`  \     /          /
   |     /|   |   \ |    / |     \   /          /
   '    | '.__'____\'_ .'_.'      | /          |
  /     \     ___.-'`\`'-.._      |/          .'
 '-.     `--'` '.     `.    `'-._/__..._       |
    `-.    __    `.     \_..,____..'    \      /
     / `'-'  `---- \      .--'''`       |    ,'.__
    /               `-...:____          |  .'/ _. ''--.
  ,'              ,'`        `\--'`.   |''`,-'-.   ,'`
.'              .'            _\    \  |,' \    _,'
'-._            '--..._   _,-'  '.   '-'..__.-'
    `.                /`-' /    |'-._  `'.___
      \         _    /|   |     /.' .`-.__..'`\
     ,-'.---'''`/`'./ `.  |-.  |/  /    _\'-._`|
    /    -''- ,'-.  dj| |   \  \      /  \   ' |
   .' .-'''-,'\   \    `|/   ',.--.   '  .'\.__`|
   | '    ,'   |   '    '   ,'     `\    '  \   \
   .     / \   '   |       /         /--.    '. '.
   /   .'  |     _,'      .'  '`'--,'.   \.   \  |
   | .'    ' _.,'         |  ___ ,'  \    |`-._  |
  /.'__.,-'''            .| '   / \   |   '    `-.
 '--'                    |    ,'  |   '   /      '|
                         |  ,'    '  _,.-'
                        .' /   _,.--'
                        |..--''
 -->