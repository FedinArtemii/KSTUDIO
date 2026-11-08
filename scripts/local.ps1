param([switch]$SetupOnly)

$ErrorActionPreference = 'Stop'
Set-Location (Split-Path -Parent $PSScriptRoot)
$local = Join-Path $PWD '.local'
$wp = Join-Path $local 'wordpress'
New-Item -ItemType Directory -Path $local -Force | Out-Null

if (!(Test-Path (Join-Path $wp 'wp-load.php'))) {
    $zip = Join-Path $local 'wordpress.zip'
    Invoke-WebRequest 'https://wordpress.org/latest.zip' -OutFile $zip
    Expand-Archive -LiteralPath $zip -DestinationPath $local
}

$plugins = Join-Path $wp 'wp-content/plugins'
if (!(Test-Path (Join-Path $plugins 'sqlite-database-integration/db.copy'))) {
    $zip = Join-Path $local 'sqlite-plugin.zip'
    Invoke-WebRequest 'https://downloads.wordpress.org/plugin/sqlite-database-integration.latest-stable.zip' -OutFile $zip
    Expand-Archive -LiteralPath $zip -DestinationPath $plugins
}

$php = (Get-Command php -ErrorAction Stop).Source
$extensions = Join-Path (Split-Path -Parent $php) 'ext'
$ini = Join-Path $local 'php.ini'
$ext = @('pdo_sqlite', 'sqlite3', 'mbstring', 'gd')
@("extension_dir=""$extensions""", 'memory_limit=256M', 'upload_max_filesize=20M', 'post_max_size=24M') +
    ($ext | ForEach-Object {"extension=$_"}) | Set-Content -Encoding ascii $ini

$themes = Join-Path $wp 'wp-content/themes'
Copy-Item -LiteralPath (Join-Path $PWD 'theme/kstudio') -Destination $themes -Recurse -Force
& $php -c $ini (Join-Path $PSScriptRoot 'install-local.php')
if ($LASTEXITCODE -ne 0) { throw 'Не удалось подготовить локальный WordPress.' }

if (!$SetupOnly) {
    & $php -c $ini -S '127.0.0.1:8174' -t $wp
}
