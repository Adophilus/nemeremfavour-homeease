// const endpoint = "https://home-ease.onrender.com/api/lodges"
const endpoint = "http://localhost:50000/api/lodges"
async function submitForm(event) {
  event.preventDefault()
  const formContainer = document.querySelector("#lodgeForm")
  const form = new FormData(formContainer)

  try {
    const res = await fetch(endpoint, {
      method: "POST",
      headers: {
        "Authorization": "Bearer <TOKEN>"
      },
      body: form
    })
  }
  catch (err) {
    console.warn(err)
  }
}
