const searchArtist = document.querySelector('#searchservice')
const priceInput = document.querySelector('#searchprice');
const ratingInput = document.querySelector('#searchrating');

if (searchArtist) {
  searchArtist.addEventListener('input', fetchServices())
  }
if(priceInput) {
  priceInput.addEventListener('input', fetchServices())
}
if(ratingInput) {
  ratingInput.addEventListener('input', fetchServices())
}

  async function fetchServices() {
  const name = encodeURIComponent(searchArtist.value);
  const price = encodeURIComponent(priceInput ? priceInput.value : 200000);
  const rating = encodeURIComponent(ratingInput ? ratingInput.value : 0);
    const response = await fetch(`../api/api_service.php?search=${name}&price=${price}&rating=${rating}`);
    const services = await response.json()

    const section = document.querySelector('.horizontal_popular_services')
    section.innerHTML = ''

    if(services.length === 0){
        const h3 = document.createElement('h3');
        h3.textContent = "No service found with that name.";
        section.appendChild(h3);
    }
    else{
    for (const service of services) {
        const li = document.createElement('li');
        li.id = 'service';
  
        const a = document.createElement('a');
        a.className = 'serviceInfo';
        a.href = `service.php?id=${service.id}`;
  
        const h3 = document.createElement('h3');
        h3.textContent = service.name;
  
        const img = document.createElement('img');
        img.src = service.image;
        img.alt = 'Service Image';
        img.width = 300;
        img.height = 250;
  
        const pArtist = document.createElement('p');
        pArtist.textContent = service.artistName;
  
        const pRating = document.createElement('p');
        pRating.textContent = service.rating;
  
        const pCategory = document.createElement('p');
        pCategory.textContent = service.category;
  
        const pCost = document.createElement('p');
        pCost.textContent = service.cost;
  
        a.append(h3, img, pArtist, pRating, pCategory, pCost);
  
        li.appendChild(a);
  
        section.appendChild(li);
      }
    }
  }
  
  