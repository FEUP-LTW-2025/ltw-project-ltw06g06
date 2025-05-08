const searchArtist = document.querySelector('#searchservice')
if (searchArtist) {
  searchArtist.addEventListener('input', async function() {
    const response = await fetch('../api/api_service.php?search=' + encodeURIComponent(this.value))
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
    });
  }