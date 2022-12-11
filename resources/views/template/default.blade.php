<!DOCTYPE html>
<html>

<head>
    @include('template.partials.head')
</head>

<style>
    .theme-white{
        background-color: #fff !important;
    }
    .theme-dark{
        background-color: #343a40 !important;
    }
    .txt-light{
        color: #fff !important;
    }
    .txt-dark{
        color: #000 !important;
    }
</style>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand">
            @include('template.partials.header')
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            @include('template.partials.sidebar')
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    @yield('submenu')
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        @include('template.partials.footer')
    </div>
    @include('modals')
    @include('template.partials.scripts')
</body>

<script src="/js/theme.js"></script>

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