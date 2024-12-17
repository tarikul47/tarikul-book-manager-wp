const pdfjsLib = window["pdfjs-dist/build/pdf"];
pdfjsLib.GlobalWorkerOptions.workerSrc =
  "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js";

let pdfDoc = null,
  currentPage = 1,
  totalPages = 0,
  pdfCanvas = document.getElementById("pdf-canvas"),
  ctx = pdfCanvas.getContext("2d");

// Load PDF
pdfjsLib.getDocument("/luisa-the-fantastic.pdf").promise.then((pdf) => {
  pdfDoc = pdf;
  totalPages = pdf.numPages;
  document.getElementById("total-pages").textContent = totalPages;

  // Populate the sidebar with page numbers
  const pageList = document.getElementById("page-list");
  for (let i = 1; i <= totalPages; i++) {
    const listItem = document.createElement("li");
    listItem.textContent = `Page ${i}`;
    listItem.setAttribute("data-page-number", i);
    listItem.classList.add("page-list-item");
    pageList.appendChild(listItem);

    // Add click event to jump to the clicked page
    listItem.addEventListener("click", (e) => {
      const pageNum = parseInt(e.target.getAttribute("data-page-number"));
      if (pageNum && pageNum !== currentPage) {
        currentPage = pageNum;
        renderPage(currentPage);
        document.getElementById("current-page").textContent = currentPage;
      }
    });
  }

  renderPage(currentPage);
});

// Render Page
// function renderPage(pageNum) {
//   pdfDoc.getPage(pageNum).then((page) => {
//     const viewport = page.getViewport({ scale: 1 });
//     pdfCanvas.height = viewport.height;
//     pdfCanvas.width = viewport.width;

//     const renderContext = {
//       canvasContext: ctx,
//       viewport: viewport,
//     };

//     page.render(renderContext).promise.then(() => {
//       document.getElementById("loading-bar").style.display = "none";
//     });
//   });
// }

function renderPage(pageNum) {
  document.getElementById("loading-bar-top").style.display = "block"; // Show loading indication
  
  pdfDoc.getPage(pageNum).then((page) => {
    const viewport = page.getViewport({ scale: 1 });
    pdfCanvas.height = viewport.height;
    pdfCanvas.width = viewport.width;

    const renderContext = {
      canvasContext: ctx,
      viewport: viewport,
    };

    page.render(renderContext).promise.then(() => {
      document.getElementById("loading-bar-top").style.display = "none";
      updateActivePage(pageNum); // Highlight the current page
      updateLoadingBar(pageNum); // Update progress
    });
  });
}

// Next and Previous Buttons
document.getElementById("next-page").addEventListener("click", () => {
  if (currentPage < totalPages) {
    currentPage++;
    renderPage(currentPage);
    document.getElementById("current-page").textContent = currentPage;
  }
});

document.getElementById("prev-page").addEventListener("click", () => {
  if (currentPage > 1) {
    currentPage--;
    renderPage(currentPage);
    document.getElementById("current-page").textContent = currentPage;
  }
});

function updateActivePage(pageNum) {
  const pageListItems = document.querySelectorAll(".page-list-item");
  pageListItems.forEach((item) => {
    item.classList.remove("active");
  });
  const activeItem = document.querySelector(`[data-page-number="${pageNum}"]`);
  if (activeItem) {
    activeItem.classList.add("active");
  }
}

function updateLoadingBar(pageNum) {
  const progress = (pageNum / totalPages) * 100;

  // Update the width of both loading bars
  document.getElementById("loading-bar-top").style.width = `${progress}%`;
  document.getElementById("loading-bar-bottom").style.width = `${progress}%`;
}
