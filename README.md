# Installation

1. Clone the repository
2. Make setup.sh executable (chmod +x setup.sh on unix systems)
3. run setup.sh

# Functional Requirements Documentation

## Overview

This document outlines the functional requirements for a multi-tenant application with a distinct separation between the
landlord (management) app and tenant-specific apps. It includes detailed descriptions of entities such as Users,
Companies, and Projects, along with specific roles and permissions.

## Tenant App

### Entities and Relationships

#### Users

- Users are crucial entities with varying roles that define their permissions within the app.
- They can belong to multiple companies.

#### Companies

- Companies are associated with multiple users.

#### Projects

- Projects are linked to both a user (as an owner) and a company.
- They define a collaborative scope between users and companies.

### User Roles and Permissions

#### Admin

- **Permissions**:
    - **CRUD operations on companies**.
    - **View, create, update, and delete users**.
    - **Create projects for any user associated with any company**.
    - **View all projects in the application**.

#### Moderator

- **Permissions**:
    - **View all users** (no CUD permissions).
    - **Create projects for themselves with any associated company**.
    - **View all projects related to their associated companies and their own projects**.

#### User (Basic Role)

- **Permissions**:
    - **View their own profile**.
    - **Create projects for themselves within the companies they are associated with**.
    - **View only their own projects**.

### Data Access

- **All roles can view user profiles**, but only admins are endowed with the permissions to manage (create, update,
  delete) these profiles.
- **Project visibility and management permissions** are dictated by the user's role, ensuring proper data isolation and
  security based on different access levels within the system.

## Landlord App

### User Registration and Tenant Creation

- **User registration is exclusive at the landlord app. Tenant users are created by workspace admins.**
- **Upon registration, a new tenant is automatically created, and the user is redirected to the tenant-specific route
  within the tenant app.**

### Super Admin Role

- **A super admin can log in to the landlord app using the credentials (Email: superadmin@example.com,
  Password: `password`).**
- **The super admin has the ability to view a list of all tenants existing within the system.**
- **The super admin can also create new tenants as needed.**

## Usage

Upon installation, the system is pre-configured with two tenants:

- **Tenant A**: Accessible at `workspace_a.local`
- **Tenant B**: Accessible at `workspace_b.local`

### Credentials for Access

Users can log into both tenants using the following credentials:

- **Admin**:
    - Email: admin@example.com
    - Password: `password`
- **Moderator**:
    - Email: moderator@example.com
    - Password: `password`
- **User** (Basic Role):
    - Email: user@example.com
    - Password: `password`
