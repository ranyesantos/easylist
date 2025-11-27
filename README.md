# Easylist

* [Easylist](#easylist)
* [About the Project ℹ](#about-the-project-ℹ)

  * [Current Scenario & Problem 🔴](#current-scenario--problem-)
  * [Application Proposal 🟢](#application-proposal-)
* [Main Technical Objectives 🛠️](#main-technical-objectives-️)
* [ER Diagram](#er-diagram)

---

# About the Project ℹ

### Current Scenario & Problem 🔴

* During high-demand periods, the online customer service — currently handled through WhatsApp — must be temporarily closed because attendants struggle to manage conversations on WhatsApp while simultaneously assisting a large number of in-store customers.

---

### Application Proposal 🟢

* Initially, this web application will serve as a **first point of contact**, presenting customers with product options so they can select the items they want to purchase. At checkout, the selected items and their details (such as size and color) will be added to a list containing customer information, delivery method, and payment preferences.

* At first, the final step of the purchase will still be completed through WhatsApp. However, according to the store owner, if the application improves the workflow, the entire checkout process will move to the web application, and WhatsApp will remain only for support.

---

# Main Technical Objectives 🛠️

* The choice of **pure PHP** allows me to build everything manually and understand how things work “under the hood.”

* Apply **SOLID principles**, which I consider the most important set of best practices in object-oriented programming.

* Develop the application with **low coupling** in mind to improve maintainability and enable automated testing.

* Implement **automated tests**, since testability is one of the most important pillars in software development.

* Deploy the application. At this time, **AWS (free tier)** is the planned hosting platform.

* Document the entire application to maintain a clear overview of what each part does, why it exists, and how it was implemented — helping with debugging and future improvements.

* Learn about **GitHub Actions** and implement a CI/CD deployment pipeline.

---

# ER Diagram

![ER Diagram](./db/diagram.svg)

---
