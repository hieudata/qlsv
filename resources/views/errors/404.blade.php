<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<main>
    <div class="container">
        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
            <h1>404</h1>
            <h2>The page you are looking for doesn't exist.</h2>
            <div class="d-flex justify-content-center">
                <a class="btn m-1" href="/">Back to home</a>
                <a class="btn m-1" href="/students">Go to Students</a>
                <a class="btn m-1" href="/faculties">Go to Faculty</a>
                <a class="btn m-1" href="/subjects">Go to Subject</a>
            </div>
            <img src="{{ asset('images/not-found.svg') }}" class="img-fluid py-5" alt="Page Not Found">
        </section>
    </div>
</main>
