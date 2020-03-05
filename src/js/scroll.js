function voirPlus(i) {

    let lastItem = document.querySelectorAll('.num num_item')
    requete.open('GET', '/item');

    requete.onload = () => {

        if(requete.status >= 200 && requete.status < 400) {
          let el = document.createElement('div');
          el.innerHTML = this.response;
          lastItem.appendChild(el);
        } else {
          console.log('error');
          }
        }

    requete.send();
}