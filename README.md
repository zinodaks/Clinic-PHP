# Clinic Appointments & Consultations - PHP

### Overview

After spending enough time learning about how to structure databases , the rules of database normalization and querying databases with SQL , I decided that it was worth the investment to learn some PHP to try to build a website that communicates with a database.

As a first website in PHP for me , and knowing that it will never go online , not too much attention was paid for security. As the purpose of this project was mainly to learn PHP.

### Concept

The concept of the website is to allow patients who are feeling sick to take appointments and describe their symptoms at a clinic. The clinic manager/doctor is in turn able to consult these patients on the days of their appointments and prescribe medication for them or cancel their appointments.

## Roles

### Patient

A patient is able to register and login to the system in order to take an appointment at a certain date to visit the clinic. The patient chooses the date and describes their symptoms. A patient is also able to view the consultations/prescriptions written for them at previous appointments at the clinic.

### Doctor / Clinic Manager

A doctor can login to the system in order to view the appointments. An appointment can be cancelled by the doctor. A prescription/consultation can be also be made for a patient , the doctor can enter a medicine name (with AJAX live suggestions from the medicines table in the database) along with directions on how to take these medications that the patient can later view from their personal accounts.

**_Design and Security were not a requirement of this project as the purpose was to learn how to build a website with a PHP backend that communicates with an SQL database. AJAX was also used when needed in order to refresh a certain part of a page without updating the whole page (mainly used in live search in this case)._**
