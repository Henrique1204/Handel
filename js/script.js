const slide = new Slide(".slide", ".slide-wrapper").init();

class Galeria {
    constructor() {
        this.galeria = document.querySelector('[data-galeria="galeria"]');
        this.lista = document.querySelectorAll('[data-galeria="lista"]');
        this.main = document.querySelector('[data-galeria="main"]');

        this.trocarimagem = this.trocarimagem.bind(this);
    }

    trocarimagem({currentTarget}) {
        this.main.src = currentTarget.src;
    }

    addEventoChange() {
        this.lista.forEach(img => {
            img.addEventListener("click", this.trocarimagem);
            img.addEventListener("mouseover", this.trocarimagem);
        })
   }

   iniciar() {
       if (this.galeria && this.lista.length && this.main) {
            this.addEventoChange();
       }

       return this;
   }
}

const galeria = new Galeria().iniciar();
