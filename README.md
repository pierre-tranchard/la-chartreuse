
User
- Username (string)
- Password (string)
- FirstName (string)
- LastName (string)
- Email (string)
- BirthDate (\DateTime)
- CreatedAt (\DateTime)
- Salt (string)
- Housings (n Housing)
- Rents (n Rent)

Housing
- Name (string)
- Address (string)
- ZipCode (string)
- City (string)
- Country (string)
- Availabilities (n Availability)
- Capacity (integer)
- Owner (1 User)
- Rents (n Rent)

Availability
- Housing (1 Housing)
- DateFrom (\DateTime)
- DateTo (\DateTime)
- PricePerDay (float)

Rent
- Housing
- DateFrom
- DateTo
- Renter (1 User)

