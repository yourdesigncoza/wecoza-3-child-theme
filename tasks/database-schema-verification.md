# Database Schema Verification

## Investigation Results from Subtask 1.5

### Current Database Implementation Status

#### PostgreSQL Connection Configuration

Found in `DatabaseService.php`:
- **Host**: `db-wecoza-3-do-user-17263152-0.m.db.ondigitalocean.com`
- **Port**: `25060`
- **Database**: `defaultdb`
- **User**: `doadmin`
- **Connection Method**: PDO with PostgreSQL driver

Configuration is stored in WordPress options:
- `wecoza_postgres_host`
- `wecoza_postgres_port`
- `wecoza_postgres_dbname`
- `wecoza_postgres_user`
- `wecoza_postgres_password`

#### Actual Database Usage

**CRITICAL FINDING**: The agents functionality is **NOT using the database** at all.

1. **Agent Display** (`agents-display-shortcode.php`):
   - Uses **hardcoded HTML** with static demo data
   - No database queries found
   - Static agents shown: Peter, Paul, John, Jane, etc.

2. **Agent Capture** (`agents-capture-shortcode.php`):
   - Form collects data but **no INSERT operations**
   - No database save functionality implemented
   - Form submission only validates, doesn't persist

3. **MainController::getAgents()**:
   - Returns **static array** of 15 demo agents
   - Comment states: "This would typically come from a database query"
   - No actual database connection used

### PRD Database Schema (Expected)

According to the PRD, these tables should exist:

#### Primary Table: `agents`
```sql
CREATE TABLE agents (
    id SERIAL PRIMARY KEY,
    title VARCHAR(50),
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    known_as VARCHAR(255),
    gender VARCHAR(20),
    race VARCHAR(50),
    id_number VARCHAR(20),
    passport_number VARCHAR(50),
    phone VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    street_address TEXT,
    city VARCHAR(255),
    province VARCHAR(255),
    postal_code VARCHAR(20),
    sace_number VARCHAR(100),
    phase_registered VARCHAR(100),
    subjects_registered TEXT,
    quantum_maths_passed BOOLEAN DEFAULT FALSE,
    quantum_science_passed BOOLEAN DEFAULT FALSE,
    criminal_record_checked BOOLEAN DEFAULT FALSE,
    criminal_record_date DATE,
    signed_agreement BOOLEAN DEFAULT FALSE,
    agreement_file_path VARCHAR(500),
    bank_name VARCHAR(255),
    account_holder VARCHAR(255),
    account_number VARCHAR(50),
    branch_code VARCHAR(20),
    account_type VARCHAR(50),
    preferred_areas TEXT, -- JSON array
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_by INT,
    CONSTRAINT email_unique UNIQUE (email),
    CONSTRAINT id_number_unique UNIQUE (id_number)
);
```

#### Related Tables (from PRD):
- `agent_absences`
- `agent_notes`
- `agent_orders`
- `agent_products`
- `agent_qa_visits`
- `agent_replacements`
- `class_agents`

### Verification Results

#### Database Schema Status: **CANNOT VERIFY**

**Reasons**:
1. No database queries executed in current code
2. No schema creation/migration code found
3. All data is static/demo data
4. Database connection exists but is unused for agents

#### Form Fields vs Expected Schema

**Form fields match PRD schema** for these columns:
- ✓ title
- ✓ first_name (labeled "First Name")
- ✓ last_name (labeled "Surname")
- ✓ known_as
- ✓ gender
- ✓ race
- ✓ id_number (SA ID)
- ✓ passport_number
- ✓ phone (labeled "Contact Number")
- ✓ email
- ✓ street_address
- ✓ city
- ✓ province
- ✓ postal_code
- ✓ sace_number
- ✓ phase_registered
- ✓ subjects_registered
- ✓ quantum_maths_passed
- ✓ quantum_science_passed
- ✓ criminal_record_checked
- ✓ criminal_record_date
- ✓ signed_agreement
- ✓ agreement_file_path (via file upload)
- ✓ bank_name
- ✓ account_holder
- ✓ account_number
- ✓ branch_code
- ✓ account_type
- ✓ preferred_areas (3 select fields)

**Missing from form**:
- status (likely set programmatically)
- created_at/updated_at (timestamps)
- created_by/updated_by (user tracking)

### Migration Implications

1. **Database functionality must be implemented** in the plugin
2. **Schema creation** needed during plugin activation
3. **All CRUD operations** need to be built from scratch
4. **Data migration** not needed (no existing data)
5. **Related tables** structure needs investigation

### Recommendations

1. **Create database schema** during plugin activation
2. **Implement AgentQueries class** with all CRUD operations
3. **Add database error handling** and fallback to MySQL
4. **Create data seeders** for testing
5. **Document actual schema** after implementation

### Next Steps for Database Implementation

1. Create table creation SQL in plugin activator
2. Implement INSERT functionality for agent capture
3. Implement SELECT queries for agent display
4. Add UPDATE/DELETE operations
5. Create indexes for performance
6. Add foreign key constraints for related tables