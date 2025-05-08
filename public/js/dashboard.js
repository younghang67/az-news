// // Toggle sidebar
// console.log("Dashboard script loaded.");

// document.getElementById("toggle-sidebar").addEventListener("click", function () {
//   document.getElementById("sidebar").classList.toggle("active");
//   document.getElementById("main-content").classList.toggle("active");
// });

// // Tab navigation
// const menuItems = document.querySelectorAll(".menu-item");
// const tabContents = document.querySelectorAll(".tab-content");

// const params = new URLSearchParams(window.location.search);
// const show = params.get("show");
// console.log("Show parameter:", show);
// if (show) {
//   menuItems.forEach((item) => {
//     const tabId = item.getAttribute("data-tab");

//     if (tabId === show) {
//       // Activate the menu item
//       item.classList.add("active");

//       // Show the corresponding tab content
//       const tabContent = document.getElementById(tabId);
//       if (tabContent) {
//         tabContent.classList.add("active");
//       }

//       // Update dashboard title
//       const titleText = item.querySelector("span")?.textContent || "";
//       document.querySelector(".dashboard-title").textContent = titleText;
//     } else {
//       item.classList.remove("active");
//       const otherTab = document.getElementById(tabId);
//       if (otherTab) otherTab.classList.remove("active");
//     }
//   });
// }

// menuItems.forEach((item) => {
//   item.addEventListener("click", function (e) {
//     if (this.getAttribute("data-tab")) {
//       e.preventDefault();

//       // Remove active class from all menu items
//       menuItems.forEach((item) => {
//         item.classList.remove("active");
//       });

//       // Add active class to clicked menu item
//       this.classList.add("active");

//       // Hide all tab contents
//       tabContents.forEach((content) => {
//         content.classList.remove("active");
//       });

//       // Show the corresponding tab content
//       const tabId = this.getAttribute("data-tab");
//       document.getElementById(tabId).classList.add("active");

//       // Update dashboard title
//       document.querySelector(".dashboard-title").textContent = this.querySelector("span").textContent;
//     }
//   });
// });

// // Handle dropdown menu tab navigation
// document.querySelectorAll(".dropdown-item").forEach((item) => {
//   item.addEventListener("click", function (e) {
//     if (this.getAttribute("data-tab")) {
//       e.preventDefault();

//       // Remove active class from all menu items
//       menuItems.forEach((item) => {
//         item.classList.remove("active");
//       });

//       // Add active class to corresponding menu item
//       const menuItem = document.querySelector(`.menu-item[data-tab="${this.getAttribute("data-tab")}"]`);
//       if (menuItem) {
//         menuItem.classList.add("active");
//       }

//       // Hide all tab contents
//       tabContents.forEach((content) => {
//         content.classList.remove("active");
//       });

//       // Show the corresponding tab content
//       const tabId = this.getAttribute("data-tab");
//       document.getElementById(tabId).classList.add("active");

//       // Update dashboard title
//       document.querySelector(".dashboard-title").textContent = this.textContent;
//     }
//   });
// });
