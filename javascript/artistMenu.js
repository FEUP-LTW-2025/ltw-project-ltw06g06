function replace(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;',
    };
    return text.replace(/[&<>"']/g, function (m) { return map[m]; });
}

function showSection(section) {
    const content = document.getElementById("content");

    switch (section) {
        case 'requests':
            fetch('../api/api_get_requests.php')
                .then(res => res.json())
                .then(requests => {
                    if (requests.length === 0) {
                        content.innerHTML = `
                                    <div class="item_List">
                                        <div class="item_header">
                                            <h2>Current Requests</h2>
                                        </div>
                                        <h4>No requests found</h4>
                                    </div>
                                `;
                        return;
                    }

                    const requestHTML = requests.map(request => `
                                <form method="post" action="actions/action_close_request.php" class="request">
                                    <input type="hidden" name="service_id" value="${request.serviceId}">
                                    <input type="hidden" name="client_id" value="${request.clientId}">
                                    <p class="request-status">Status: ${request.status}</p>
                                    <div class="request-details">
                                        <img src="${request.serviceImg}" alt="Service Image">
                                        <div class="request-info">
                                            <h4>${replace(request.serviceName)}</h4>
                                            <p>Category: ${request.category}</p>
                                            <p>Date: ${request.date}</p>
                                            <p>Client: ${replace(request.clientName)}</p>
                                            <p>Description: ${replace(request.request)}</p>
                                        </div>
                                    </div>
                                    ${request.status !== 'COMPLETE' ? `
                                        <button type="submit" name="mark_complete">Done</button>
                                    ` : `
                                        <p class="completed-label">✅</p>
                                    `}
                                </form>
                            `).join('');

                    content.innerHTML = `
                                <div class="item_List">
                                    <div class="item_header">
                                        <h2>Current Requests</h2>
                                    </div>
                                    ${requestHTML}
                                </div>
                            `;
                })
                .catch(error => {
                    console.error("Error fetching requests:", error);
                    content.innerHTML = `<p>Failed to load requests.</p>`;
                });
            break;
        case 'customRequests':
            fetch('../api/api_get_custom_requests.php')
                .then(res => res.json())
                .then(requests => {
                    if (requests.length === 0) {
                        content.innerHTML = `
                                    <div class="item_List">
                                        <div class="item_header">
                                            <h2> Custom Requests</h2>
                                        </div>
                                        <h4>No requests found</h4>
                                    </div>
                                `;
                        return;
                    }

                    const requestHTML = requests.map(request => `
                                <form method="post" action="actions/action_close_request.php" class="request">
                                    <input type="hidden" name="service_id" value="${request.serviceId}">
                                    <input type="hidden" name="client_id" value="${request.clientId}">
                                    <p class="request-status">Status: ${request.status}</p>
                                    <div class="request-details">
                                        <img src="${request.serviceImg}" alt="Service Image">
                                        <div class="request-info">
                                            <h4> ${replace(request.serviceName)}</h4>
                                            <p>Date: ${request.date}</p>
                                            <p>Client: ${replace(request.clientName)})</p>
                                            <p>Descrition: ${replace(request.serviceDescription)} </p>
                                        </div>
                                    </div>
                                    ${request.status !== 'COMPLETE' ? `
                                        <button type="submit" name="mark_complete">Done</button>
                                    ` : `
                                        <p class="completed-label">✅</p>
                                    `}
                                </form>
                            `).join('');

                    content.innerHTML = `
                                <div class="item_List">
                                    <div class="item_header">
                                        <h2>Custom Requests</h2>
                                    </div>
                                    ${requestHTML}
                                </div>
                            `;
                })
                .catch(error => {
                    console.error("Error fetching requests:", error);
                    content.innerHTML = `<p>Failed to load requests.</p>`;
                });
            break;
        case 'services':
            fetch('../api/api_get_services.php')
                .then(res => res.json())
                .then(services => {
                    const container = document.getElementById("content");
                    const html = `
                <div class="item_List">
                    <div class="item_header">
                        <h2>Your Services:</h2>
                        <a href="createService.php">Create new Service</a>
                    </div>
                <div id="servicesList"></div>
            `;
                    container.innerHTML = html;

                    const list = document.getElementById("servicesList");

                    services.forEach(service => {
                        const serviceEl = document.createElement("div");
                        serviceEl.className = "service";

                        serviceEl.innerHTML = `
                    <a href="service.php?id=${encodeURIComponent(service.id)}">
                        <h3 class="service_title">${replace(service.name)}</h3>
                        <div class="service_details">
                            <img src="${(service.image)}" alt="Service Image">
                            <div class="service-info">
                                <h4>${replace(service.description)}</h4>
                                <p>Category: ${replace(service.category)}</p>
                                <p class="rating">Rating: ${service.rating}</p>
                                <p>Price: ${(service.cost)}</p>
                                <p>Requests: ${(service.requests)}</p>
                            </div>
                        </div>
                    </a>
                `;
                        list.appendChild(serviceEl);
                    });
                })
                .catch(error => {
                    console.error("Error fetching services:", error);
                    const container = document.getElementById("content");
                    container.innerHTML = "<p>Failed to load services.</p>";
                });
            break;
        default:
            content.innerHTML = "<p>Unknown section</p>";
    }

    const buttons = document.querySelectorAll("#options button");
    buttons.forEach(btn => btn.classList.remove("active"));

    const clickedButton = [...buttons].find(btn => btn.getAttribute("onclick").includes(section));
    if (clickedButton) clickedButton.classList.add("active");
}

document.addEventListener("DOMContentLoaded", function () {
    showSection('requests');
});
