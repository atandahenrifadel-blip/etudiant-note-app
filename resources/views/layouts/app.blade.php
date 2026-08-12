<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    {{-- Ceci est un commentaire Blade (moteur de templates de Laravel) --}}
    <title>Gestion Étudiants & Notes</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; background: #f5f6fa; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #2c3e50; color: white; }
        .btn { display: inline-block; padding: 6px 12px; border-radius: 4px; text-decoration: none; color: white; }
        .btn-primary { background: #2980b9; }
        .btn-danger { background: #c0392b; border: none; cursor: pointer; }
        .flash-success { background: #2ecc71; color: white; padding: 10px; margin-bottom: 1rem; border-radius: 4px; }
        form.inline { display: inline; }
    </style>
</head>
<body>

    {{-- @if / @endif : structure conditionnelle Blade --}}
    {{-- session('success') récupère le message flash défini dans le contrôleur --}}
    @if (session('success'))
        <div class="flash-success">{{ session('success') }}</div>
    @endif

    {{-- @yield affiche le contenu défini par @section dans les autres vues --}}
    @yield('content')

</body>
</html>
