<?php
include 'db.php';

if (isset($_POST['submit_comentario'])) {
    $nombre = htmlspecialchars(trim($_POST['nombre'])); 
    $usuario = htmlspecialchars(trim($_POST['usuario'])); 
    $email = htmlspecialchars(trim($_POST['email']));
    $nota = htmlspecialchars(trim($_POST['nota']));
    $fechanota = date('Y-m-d H:i:s');

    if (!empty($nombre) && !empty($usuario) && !empty($email) && !empty($nota)) {
        
        $stmt = $conn->prepare("INSERT INTO comentarios (nombre, usuario, email, nota, fechanota) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nombre, $usuario, $email, $nota, $fechanota);

        if ($stmt->execute()) {
             header("Location: portafolio.php#comentarios");
             exit();
        } else {
            echo "<p class='alert alert-danger text-center mt-3'>Error al enviar el comentario: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p class='alert alert-warning text-center mt-3'>Por favor, completa todos los campos del formulario.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Star Wars: El Legado de la Fuerza</title>
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/128/16070/16070284.png">
    <meta name="description" content="Explora el vasto universo de Star Wars: películas, series, personajes, naves y el orden cronológico de la saga. ¡Que la Fuerza te acompañe!">
    <meta name="keywords" content="Star Wars, La Fuerza, Jedi, Sith, películas, series, orden cronológico, Halcón Milenario, Darth Vader, Luke Skywalker">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            background-color: #000; 
            color: #eee; 
            font-family: 'Arial', sans-serif; 
        }
        .bg-primary-sw {
            background-color: #1a1a1a !important; 
        }
        .text-yellow-sw {
            color: #ffe81f !important; 
        } 
        .btn-starwars {
            background-color: #ffe81f;
            color: #000;
            border-color: #ffe81f;
            font-weight: bold;
        }
        .btn-starwars:hover {
            background-color: #ccbe00;
            border-color: #ccbe00;
            color: #000;
        }
        .section-bg-dark {
            background-color: #0a0a0a; 
            padding: 5rem 0;
        }
        .section-bg-light-sw {
            background-color: #151515; 
            padding: 5rem 0;
        }
        .img-fluid {
            border: 2px solid #ffe81f; 
            box-shadow: 0 0 10px rgba(255, 232, 31, 0.5); 
        }
        
        #laFuerza .row {
            min-height: 400px; 
            align-items: center; 
        }
        
        .accordion-button {
            background-color: #333 !important; 
            color: #ffe81f !important; 
            border-color: #ffe81f !important;
            font-weight: bold;
        }
        .accordion-button:not(.collapsed) {
            background-color: #444 !important; 
            color: #ffe81f !important;
            box-shadow: inset 0 -1px 0 rgba(255, 232, 31, 0.1);
        }
        .accordion-body {
            background-color: #222; 
            color: #eee;
        }
        .accordion-item {
            border: 1px solid #ffe81f; 
            margin-bottom: 10px; 
        }

        #hero-image-banner {
            background: url('https://www.impericon.com/cdn/shop/collections/20230320_star_wars__header_9981fc94-2b8b-4147-a5be-ed2c43011389.webp?v=1719220048') no-repeat center center/cover;
            height: 600px; 
            position: relative; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            text-align: center;
            color: #fff;
        }
        #hero-image-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5); 
            z-index: 1;
        }
        #hero-image-banner > .container {
            position: relative;
            z-index: 2;
        }

        .footer-link {
            color: #eee; 
            text-decoration: none; 
            transition: color 0.3s ease;
        }
        .footer-link:hover {
            color: #ffe81f; 
        }
        .social-icon {
            color: #ffe81f; 
            font-size: 1.5rem; 
            margin: 0 10px; 
            transition: color 0.3s ease;
        }
        .social-icon:hover {
            color: #ccbe00; 
        }
    </style>
</head>
<body>
    <section id="hero-image-banner">
        <div class="container">
            <h1 class="display-3 text-yellow-sw">Star Wars: Una Galaxia Muy, Muy Lejana</h1>
            <p class="lead">Descubre las historias, personajes y naves de la saga</p>
            <a href="#ordenCronologico" class="btn btn-starwars btn-lg">Explora el universo</a>
        </div>
    </section>
    
    <hr class="border-secondary my-0">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand text-yellow-sw" href="#">Star Wars, Página de un Fan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#hero-image-banner">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#laFuerza">La Fuerza</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#personajes">Personajes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#naves">Naves</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#ordenCronologico">Orden Cronológico</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#comentarios">Comentarios</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <hr class="border-secondary my-0">

    <section id="laFuerza" class="section-bg-dark text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 order-md-2 d-flex flex-column justify-content-center h-100"> 
                    <h2 class="text-yellow-sw mb-3">El Despertar de la Fuerza</h2>
                    <p>La Fuerza es un campo de energía mística que une toda la vida en la galaxia. Es utilizada por los Jedi, quienes la usan para la paz y la justicia, y por los Sith, quienes la corrompen para obtener poder y dominio. ¿De qué lado te inclinas?</p>
                </div>
                <div class="col-md-6 order-md-1 h-100">
                    <img src="https://img.europapress.es/fotoweb/fotonoticia_20230626145247_690.jpg" 
                    class="img-fluid rounded" alt="Mano sosteniendo un sable de luz azul, representando La Fuerza">
                </div>
            </div>
        </div>
    </section>

    <hr class="border-secondary my-0">

    <section id="personajes" class="section-bg-light-sw text-white">
        <div class="container">
            <h2 class="text-center text-yellow-sw mb-5">Héroes y Villanos Inolvidables</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <img src="https://cdn.hobbyconsolas.com/sites/navi.axelspringer.es/public/media/image/2019/11/star-wars-nueva-esperanza-luke-skywalker.jpg?tf=3840x" class="img-fluid rounded-circle mb-3" alt="Luke Skywalker">
                    <h3>Luke Skywalker</h3>
                    <p>El héroe granjero de Tatooine que descubrió su destino como Jedi.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <img src="https://lumiere-a.akamaihd.net/v1/images/darth-vader-main_4560aff7.jpeg?region=0%2C67%2C1280%2C720" class="img-fluid rounded-circle mb-3" alt="Darth Vader">
                    <h3>Darth Vader</h3>
                    <p>El temible Lord Sith y antiguo Jedi, Anakin Skywalker.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <img src="https://sm.ign.com/ign_latam/news/o/obi-wan-ke/obi-wan-kenobi-ewan-mcgregor-opens-up-about-upcoming-star-wa_9uy8.jpg" class="img-fluid rounded-circle mb-3" alt="Obi-Wan Kenobi">
                    <h3>Obi-Wan Kenobi</h3>
                    <p>Kenobi es un maestro Jedi de la Antigua República Galáctica, y maestro de Anakin y Luke Skywalker.</p>
                </div>
            </div>
        </div>
    </section>

    <hr class="border-secondary my-0">

    <section id="naves" class="section-bg-dark text-white">
        <div class="container">
            <h2 class="text-center text-yellow-sw mb-5">Las Naves Más Emblemáticas</h2>
            <p class="text-center">Desde el ágil Halcón Milenario hasta los imponentes Destructores Estelares, la tecnología es una parte fundamental del universo de Star Wars. Cada nave cuenta una historia y ha sido testigo de innumerables batallas.</p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div id="starwarsCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://cdn.hobbyconsolas.com/sites/navi.axelspringer.es/public/media/image/2017/11/halcon-milenario.jpg?tf=3840x" class="d-block w-100 img-fluid" alt="Halcón Milenario">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5 class="text-yellow-sw">Halcón Milenario</h5>
                                    <p>La nave más rápida de la galaxia.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="https://www.shutterstock.com/editorial/image-editorial/N1Tdc45dMdz0cb54NDgxOQ==/luke-skywalker-star-wars-x-wing-fighter-aircraft-440nw-5754782c.jpg" class="d-block w-100 img-fluid" alt="X-Wing">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5 class="text-yellow-sw">X-Wing</h5>
                                    <p>El caza estelar favorito de la Alianza Rebelde.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjtXSKQbyw4ZtAIIasWcVkgmwtEuWcapISUcIOA5-uN8PyHRv66JDgphc-OaKEXeKNg7_9bVx1hAqe3ZKQxeiOlSPARxtRBaxYkdx_7C1XMBEkAFPbdSzm_7Bc1o7_jhZOSSeSJInQNk4uf/s1600/ImpStarDestroyer-SWI125.jpg" class="d-block w-100 img-fluid" alt="Destructor Estelar">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5 class="text-yellow-sw">Destructor Estelar</h5>
                                    <p>La imponente nave de guerra del Imperio Galáctico.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="https://pm1.aminoapps.com/6177/6ff12072ea3e7f7bd9523a016311914fe981094d_hq.jpg" class="d-block w-100 img-fluid" alt="Caza TIE">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5 class="text-yellow-sw">Caza TIE</h5>
                                    <p>El caza estelar favorito del Imperio Galáctico.</p>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#starwarsCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#starwarsCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="border-secondary my-0">

    <section id="ordenCronologico" class="section-bg-light-sw text-white">
        <div class="container">
            <h2 class="text-center text-yellow-sw mb-5">El Orden de la Saga: Películas y Series</h2>
            <p class="text-center mb-4">El universo Star Wars es vasto. Aquí te mostraremos el orden más común para disfrutar de la historia completa.</p>

            <div class="accordion" id="starWarsOrderAccordion">

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingChronological">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseChronological" aria-expanded="false" aria-controls="collapseChronological">
                            Orden Cronológico de la Historia
                        </button>
                    </h2>
                    <div id="collapseChronological" class="accordion-collapse collapse" aria-labelledby="headingChronological" data-bs-parent="#starWarsOrderAccordion">
                        <div class="accordion-body">
                            <p>Esta es la forma de ver las películas y series según la línea de tiempo de la galaxia, desde el pasado más remoto hasta los eventos más recientes.</p>
                            <ol>
                                <li>Episodio I: La Amenaza Fantasma</li>
                                <li>Episodio II: El Ataque de los Clones</li>
                                <li>Star Wars: The Clone Wars (Serie)</li>
                                <li>Episodio III: La Venganza de los Sith</li>
                                <li>Star Wars: La Remesa Mala (Serie)</li>
                                <li>Obi-Wan Kenobi (Serie)</li>
                                <li>Andor (Serie)</li>
                                <li>Star Wars Rebels (Serie)</li>
                                <li>Rogue One: Una Historia de Star Wars</li>
                                <li>Episodio IV: Una Nueva Esperanza</li>
                                <li>Episodio V: El Imperio Contraataca</li>
                                <li>Episodio VI: El Retorno del Jedi</li>
                                <li>The Mandalorian (Serie)</li>
                                <li>El Libro de Boba Fett (Serie)</li>
                                <li>Ahsoka (Serie)</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div> </div>
    </section>
    
    <section id="comentarios" class="section-bg-dark text-white py-5">
        <div class="container">
            <h2 class="text-center text-yellow-sw mb-5">Deja tu Comentario Estelar</h2>

            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <form action="portafolio.php" method="POST" class="p-4 border border-warning rounded shadow-lg bg-dark">
                        <h4 class="text-yellow-sw mb-4 text-center">¡Escribe tu Nota!</h4>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre y Apellido:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Nombre de Usuario:</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="nota" class="form-label">Tu Nota/Comentario:</label>
                            <textarea class="form-control" id="nota" name="nota" rows="5" required></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="submit_comentario" class="btn btn-starwars btn-lg">Enviar Comentario</button>
                        </div>
                    </form>

                    <hr class="my-5 border-secondary">

                    <h3 class="text-center text-yellow-sw mb-4">Comentarios de la Galaxia</h3>
                    <div id="lista-comentarios">
                        <?php
                        // Ajuste en la selección para incluir la columna 'usuario'
                        $sql = "SELECT id, nombre, usuario, email, nota, fechanota FROM comentarios ORDER BY id DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<div class="card bg-secondary text-white mb-3 shadow">';
                                echo '  <div class="card-body">';
                                // Mostrar el nombre y el nombre de usuario
                                echo '    <h5 class="card-title text-yellow-sw">' . htmlspecialchars($row["nombre"]) . ' (' . htmlspecialchars($row["usuario"]) . ')</h5>';
                                echo '    <h6 class="card-subtitle mb-2 text-muted">' . htmlspecialchars($row["email"]) . '</h6>';
                                echo '    <p class="card-text">' . nl2br(htmlspecialchars($row["nota"])) . '</p>';
                                echo '    <p class="card-text"><small class="text-white-50">Enviado el: ' . htmlspecialchars($row["fechanota"]) . '</small></p>';
                                echo '  </div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p class="text-center text-muted">¡Sé el primero en dejar un comentario estelar!</p>';
                        }
                        $conn->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="border-secondary my-0">

    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container text-center text-md-start">
            <div class="row text-center text-md-start">
                
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-yellow-sw">Star Wars</h5>
                    <p>Un tributo a la saga más épica de la galaxia. Explora todo sobre la Fuerza, sus personajes y sus naves.</p>
                </div>

                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-yellow-sw">Enlaces Rápidos</h5>
                    <p><a href="#laFuerza" class="footer-link">La Fuerza</a></p>
                    <p><a href="#personajes" class="footer-link">Personajes</a></p>
                    <p><a href="#naves" class="footer-link">Naves</a></p>
                    <p><a href="#ordenCronologico" class="footer-link">Orden Cronológico</a></p>
                    <p><a href="#comentarios" class="footer-link">Comentarios</a></p>
                </div>

                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-yellow-sw">Síguenos</h5>
                    <p>Mantente conectado con la comunidad de fans de Star Wars.</p>
                    <div class="d-flex justify-content-center justify-content-md-start">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>

            <hr class="mb-4 border-secondary">

            <div class="row align-items-center">
                <div class="col-md-7 col-lg-8">
                    <p class="text-center text-md-start mb-0">
                        &copy; 2025 Todos los derechos reservados por: <a href="#" class="footer-link"><strong class="text-yellow-sw">Gustavo Maneiro. Que la Fuerza te acompañe.</strong></a>
                    </p>
                </div>
                <div class="col-md-5 col-lg-4">
                    <div class="text-center text-md-end mt-3">
                        </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>