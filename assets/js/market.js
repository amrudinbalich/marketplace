const form = document.getElementById('filter-form');
const defaultFilters = getDefaults(); // use to reset form
    
const articlesContainer = document.getElementById('articles-container');
const filterButton = document.getElementById('filter-button');
const loadingSpinner = document.getElementById('loading-spinner');
const articlesCount = document.getElementById('articles-count');

// get results
form.addEventListener('submit', async (e) => {
    e.preventDefault();

    // prepare
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);

    try {

        // get data
        const response = await fetch(form.action, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'
            }
        });

        const result = await response.json();
        const articles = result.articles;

        if(!articles) {
            throw new Error('Something went wrong while fetching.');
        }

        // form.reset();
        processFetchResult(articles);

    } catch(error) {
        console.error(error);
    }
    
    
});


// helpers
function getDefaults() {
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);

    return data;
}

function processFetchResult(articles) {
    // loading state
    filterButton.setAttribute('disabled', true);
    loadingSpinner.classList.remove('d-none');
    articlesCount.textContent = articles.length;
    articlesContainer.innerHTML = '';

    // repopulate
    articles.forEach(article => {
        const articleElement = document.createElement('div');
        articleElement.classList.add('col-md-4', 'mb-3');

        articleElement.innerHTML = `
            <div class="card cursor-pointer h-100" onclick="window.location.href = '/market/article/${article.id}'">
                <div class="card-body">
                    <h6 class="card-title">${article.title}</h6>
                    <p class="card-text"><strong>${article.price} KM</strong></p>
                </div>
            </div>
        `;

        articlesContainer.appendChild(articleElement);
    });

    // end loading
    filterButton.removeAttribute('disabled');
    loadingSpinner.classList.add('d-none');
}