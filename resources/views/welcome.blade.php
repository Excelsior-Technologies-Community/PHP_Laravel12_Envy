<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Env Manager Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6; padding: 40px; color: #1f2937; }
        .container { max-width: 900px; margin: auto; }
        h1 { text-align: center; color: #111827; margin-bottom: 30px; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .card { background: white; padding: 30px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; transition: transform 0.2s; }
        .card:hover { transform: translateY(-5px); }
        .card h3 { font-size: 14px; color: #6b7280; text-transform: uppercase; margin-bottom: 10px; }
        .card p { font-size: 24px; font-weight: bold; color: #2563eb; }

        .env-section { background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚙️ Environment Manager</h1>

        <div class="stats-grid">
            <div class="card">
                <h3>Total Env Edits</h3>
                <p>{{ $totalEdits }}</p>
            </div>
            <div class="card">
                <h3>Last Modified</h3>
                <p style="font-size: 18px;">
                    @if($lastEdit)
                        {{ $lastEdit->created_at->format('d M, Y H:i') }}
                    @else
                        Never
                    @endif
                </p>
            </div>
        </div>

        <div class="env-section">
            <h2>Current Configuration</h2>
            <p>You can manage your .env file settings here.</p>
        </div>
    </div>
</body>
</html>