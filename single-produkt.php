<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package OceanWP WordPress theme
 */
get_header();
?>

<head>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri()?>/custom.css">
</head>

	    <section id="primary">
		<div id="main-single" class="site-main">

        <ul class="breadcrumb">
        <li><a href="http://katjalevring.dk/kea/10_eksamensprojekt/made_by_nicholas/">Hjem</a></li>
	    <li><a href="http://katjalevring.dk/kea/10_eksamensprojekt/made_by_nicholas/produkter/">Produktoversigt</a></li>
        <li>Produktdetaljer</li>
        </ul>

        <article id="artikel_single">
        <img class="pic_single" src="" alt="" />
        <div class="div_single">
        <h2 class="titel_single"></h2>
        <p class="beskrivelse_single"></p>
        <p class="pris_single"></p>
        <button class="tilføj_single">Tilføj til kurv</button>
        <div id="oplysninger_section">
        <p>Detaljer ↓</p>
        <div class="produkt_detaljer">
        <div class="line1"></div>
        <div class="line2"></div>
        </div>
        </div>
        </div>
        </article>

        <p class="beskrivelse_dropdown"></p>

        <h2 id="h2_lignende">Andre kunder har købt</h2>

        <section id="andre_produkter"></section>

        <template>
        <article class="lignende_produkter">
        <img class="image" src="" alt="" />
        <div class="template-tekst">
        <h2 class="titel"></h2>
		<p class="pris"></p>
        </div>
        </article>
        </template>

        </div><!-- #main-single -->

        <script>

        let produkt;
        let produkter;
		const url = "https://katjalevring.dk/kea/10_eksamensprojekt/made_by_nicholas/wp-json/wp/v2/produkt/"+<?php echo get_the_ID() ?>;
        const produkterUrl = "https://katjalevring.dk/kea/10_eksamensprojekt/made_by_nicholas/wp-json/wp/v2/produkt?per_page=3";
        const produktTemplate = document.querySelector("template");
	    const ekstra_info = document.querySelector("#oplysninger_section");
        const ekstra_beskrivelse = document.querySelector(".beskrivelse_dropdown");
        const linje = document.querySelector(".line2");

        ekstra_beskrivelse.style.display = "none";
        ekstra_info.addEventListener("click", foldOut);
        
		async function getJson() {
  		const response = await fetch(url);
  		produkt = await response.json();
        console.log(produkt);
  		visProdukt();
		}

        async function Json() {
  		const result = await fetch(produkterUrl);
  		produkter = await result.json();
        console.log(produkter);
  		visAndreProdukter();
		}

        function foldOut() {
        if (ekstra_beskrivelse.style.display == "none") {
        ekstra_beskrivelse.style.display = "block";
        linje.style.display = "none";
        } else {
        ekstra_beskrivelse.style.display = "none";
        linje.style.display = "block";
        }
    }

        function visProdukt() {
            document.querySelector(".titel_single").textContent = produkt.title.rendered;
            document.querySelector(".pic_single").src = produkt.billede.guid;
            document.querySelector(".beskrivelse_single").textContent = produkt.beskrivelse;
            document.querySelector(".pris_single").textContent = produkt.pris + "kr";
            document.querySelector(".beskrivelse_dropdown").innerHTML = produkt.beskrivelse_dropdown;
        }

            
        function visAndreProdukter() {
        const liste = document.querySelector("#andre_produkter");
        liste.textContent = "";
        produkter.forEach((produkt) => {
        let klon = produktTemplate.cloneNode(true).content;
        klon.querySelector(".titel").textContent = produkt.title.rendered;
        klon.querySelector(".image").src = produkt.billede.guid;
		klon.querySelector(".pris").textContent = produkt.salgspris + " " + "kr";
	    klon.querySelector(".lignende_produkter").addEventListener("click", () => {
        location.href = produkt.link;

        });

        liste.appendChild(klon); 
      
        });
    }

        getJson();

        Json();

    </script>

		
	</section><!-- #primary -->

<?php
get_footer();
