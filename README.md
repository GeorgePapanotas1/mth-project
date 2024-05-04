# Installation

1. Clone the repository
2. Make setup.sh executable (`chmod +x` setup.sh on unix systems)
3. run setup.sh

# Functional Requirements Documentation

## Tenant App

### Entities and Relationships

#### Users

- Users are crucial entities with varying roles that define their permissions within the app.
- They can belong to multiple companies.

#### Companies

- Companies are associated with multiple users.

#### Projects

- Projects are linked to both a user (as creator) and a company.

### User Roles and Permissions

#### Admin

- **Permissions**:
    - **CRUD operations on companies**.
    - **View, create, update, and delete users**.
    - **Create projects for any user associated with any company**.
    - **View all projects in the application**.

#### Moderator

- **Permissions**:
    - **View all users but cannot delete, create or edit**.
    - **Create projects for themselves with any associated company**.
    - **View their own projects and all projects related to their associated companies**.

#### User (Basic Role)

- **Permissions**:
    - **View all users but cannot edit, create or delete.**.
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
    - **The `/register` route is disabled for tenant domains and result in a 404 page. It's only enabled in the landlord
      app and acts as a tenant registration form**.
    - **Upon registration, a new tenant is automatically created, and the user is redirected to the tenant-specific
      route
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

## Packages Used

- **Spatie Multi-Tenancy**
- **Livewire**
- **Spatie Permissions**
- **Tuupola Base62**
- **Laravel Pest**

## Architecture overview

Whilst this is a Laravel app, the core business logic is seperated and moved into src/Mth directory.
In this directory, I have separated the code based on the different contexts.

- **Common**: Common classes and utilities that are helpful across the app.
    - **Config**: A module to interact with the Laravel config.
    - **Constants**: Enum files with various constants of the app.
    - **Container**: Exposed facade to interact with Laravel's `app()` container.
    - **Helpers**: A set of helpers like UuidHelper that transforms a Uuid on a base62 string and vise versa.
    - **Core**: Core classes that are used by the other modules on a polymorphic manner.
        - ICrudRepository: Base contract of a CRUD repository. Establishes a set of common CRUD functions.
        - ICrudService: Base contract of a CRUD Service layer. Establishes a set of common CRUD functions.
        - BaseCrudRepository: Abstract implementation of ICrudRepository. Forces the user to implement a getModel()
          function that returns an eloquent model and acts as the entrypoint for all query builders.
        - AbstractCrudService: Abstract implementation of ICrudService. Uses the ICrudRepository dependency to perform
          common CRUD functions.

Using the BaseCrudRepository and AbstractCrudService any model Crud Repo & Service comes pre-configures with a varing
set of function that are reusable.

- **Landlord / Tenant**: These are the basic domain modules. Each of these can potentially be broken down by more
  domains.
- Each domain is seperated by concern or layer.
    - **Adapters**: The name is derived from the Hexagonal Architecture. Adapters include Driver and Driver adapters.
      Driver
      adapters are the entry points of the app like HTTP, Commands, Jobs and any other utility that can execute BL code.
      Driver adapters are the output ports. You can find more
      info [here](https://medium.com/idealo-tech-blog/hexagonal-ports-adapters-architecture-e3617bcf00a0). On our case,
      Adapters include any Laravel specific entrypoint like HTTP Controller, Command etc. and the basic Driven adapter
      that is Eloquent models.
    - **Core**: Core module includes only business logic layers and its forbidden to use any Laravel specific class.
      It's purpose is to be easily reusable and decoupled from the framework.

### Core Modules overview

Core module contains the following directories:

- Constants: Constants and enums dependant to the bounded context
- DTO: DT Objects for cross class data access. I separate my DTOs by action:
    - Forms: Input DTO used to store or update an entity.
    - Queries: Input DTO used to query an entity. Think filters.
    - Projections: Output DTO used to pass an entity from the final BL layer to the Driver as a response.
    - Presenters: Output DTO used to present an entity - Omitted for this project - useful on HATEOAS / HAL based
      architectures.
- Exceptions: Bounded-context specific exceptions.
- Repository: DAO for the entities of the context.
- Services: Business logic services and layers.
    - CrudServices: Services that are responsible for Data access.
    - Authorization: On more complex scenarios, they are responsible for authorising actions.
    - Services: The uppermost context layer. This layer is the one that Driving Adapters use and consolidates business
      logic actions.

On a real-world scenario the core module would also be extended to include items like:

- Facades
- Factories
- Adapters
- Decorators
- Domain / Models
- more business logic specific item.
