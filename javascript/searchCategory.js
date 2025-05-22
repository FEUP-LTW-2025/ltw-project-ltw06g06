const searchArtistC = document.querySelector('#searchCategoryService')
const priceInputC = document.querySelector('#searchCategoryPrice');
const ratingInputC = document.querySelector('#searchCategoryRating');

if (searchArtistC) {
  searchArtistC.addEventListener('input', fetchServices)
  }
if(priceInputC) {
  priceInputC.addEventListener('blur', fetchServices)
}
if(ratingInputC) {
  ratingInputC.addEventListener('blur', fetchServices)
}

  async function fetchServices() {
  const name = encodeURIComponent(searchArtistC.value);
  const price = encodeURIComponent(priceInputC && priceInputC.value !== '' ? priceInputC.value : 200000);
  const rating = encodeURIComponent(ratingInputC && ratingInputC.value !== '' ? ratingInputC.value : 0);
  const categoryEll = document.querySelector('#category');
  console.log(categoryEll.value);
  const category = encodeURIComponent(categoryEll.value);

    const response = await fetch(`../api/api_category_service.php?search=${name}&price=${price}&rating=${rating}&category=${category}`);
    const services = await response.json()

    const section = document.querySelector('.horizontal_popular_services')

    document.querySelector("input[id='category']").value = document.querySelector('#category').value;

    section.innerHTML = ''

    if(services.length === 0){
        const h3 = document.createElement('h3');
        h3.textContent = "No service found.";
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
  
  