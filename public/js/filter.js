window.onload = () => {
    const FilterForm = document.querySelector("#filterForm");
    document.querySelectorAll("#filterForm input").forEach(input => {
        input.addEventListener("change", () => {
            const Form = new FormData(FilterForm);

            const Params = new URLSearchParams();


            Form.forEach((value, key) => {
                Params.append(key, value);
            });

            const Url = new URL(window.location.href);
            
            fetch(Url.pathname + "?" + Params.toString() + "&ajax=1", {
                headers: {
                    "x-Requested-with" : "XMLHtppRequest"
                }
            }).then(response => 
                    response.json()
            ).then(data => {
                console.log(data);
                const content = document.querySelector("#content");
                content.innerHTML = data.content;
            })
        })
    });
}