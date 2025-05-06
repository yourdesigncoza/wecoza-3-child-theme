# Linear Integration for WeCoza

This directory contains scripts and documentation for integrating with Linear, a project management tool that replaces GitHub Issues in our workflow.

## Contents

- `linear-cli.sh`: Command-line interface for interacting with Linear
- `linear-cli-best-practices.md`: Best practices and guidelines for using Linear API

## Setup

### Prerequisites

1. A Linear account with access to the Wecoza team
2. Linear API key (generate from Linear settings)

### Installation

1. Make the script executable:
   ```bash
   chmod +x linear-cli.sh
   ```

2. Set your Linear API key as an environment variable:
   ```bash
   export LINEAR_API_KEY="your_linear_api_key"
   ```

   For permanent storage, add this to your `.bashrc` or `.zshrc` file.

## Usage

### Basic Commands

The Linear CLI supports the following commands:

#### 1. LINEAR-PULL

Fetches and displays detailed information about a Linear issue.

```bash
./linear-cli.sh LINEAR-PULL WEC-56
```

#### 2. LINEAR-REVIEW

Moves an issue to "In Review" status and adds an implementation summary comment.

```bash
./linear-cli.sh LINEAR-REVIEW WEC-56
```

#### 3. LINEAR-CREATE

Creates a new Linear issue.

```bash
./linear-cli.sh LINEAR-CREATE "Issue Title" "Issue Description" "Feature,Bug"
```

For interactive mode:

```bash
./linear-cli.sh LINEAR-CREATE AUTO_GENERATE
```

### Integration with CLI Shortcodes

To use these commands with the existing CLI shortcode system, add the following to your `cli.sh` script:

```bash
# Linear CLI integration
if [[ $1 == "(LINEAR-PULL)"* ]]; then
    issue_id=$(echo $1 | sed -n 's/.*(\([^)]*\)).*/\1/p')
    ./linear/linear-cli.sh LINEAR-PULL "$issue_id"
    exit 0
fi

if [[ $1 == "(LINEAR-REVIEW)"* ]]; then
    issue_id=$(echo $1 | sed -n 's/.*(\([^)]*\)).*/\1/p')
    ./linear/linear-cli.sh LINEAR-REVIEW "$issue_id"
    exit 0
fi

if [[ $1 == "(LINEAR-CREATE)"* ]]; then
    if [[ $1 == "(LINEAR-CREATE)" ]]; then
        ./linear/linear-cli.sh LINEAR-CREATE AUTO_GENERATE
    else
        # Extract parameters from command
        title=$(echo $1 | sed -n 's/.*("\([^"]*\)").*/\1/p')
        body=$(echo $1 | sed -n 's/.*("[^"]*")("\([^"]*\)").*/\1/p')
        labels=$(echo $1 | sed -n 's/.*("[^"]*")("[^"]*")("\([^"]*\)").*/\1/p')
        
        ./linear/linear-cli.sh LINEAR-CREATE "$title" "$body" "$labels"
    fi
    exit 0
fi
```

## Troubleshooting

### Common Issues

1. **Authentication Errors**
   - Ensure your LINEAR_API_KEY is set correctly
   - Check that your API key has not expired
   - Verify you have the necessary permissions

2. **Command Failures**
   - Check the error message for specific issues
   - Refer to `linear-cli-best-practices.md` for common pitfalls
   - Ensure you're using the correct issue identifiers

3. **Missing Dependencies**
   - The script works best with `jq` installed for JSON parsing
   - Install with: `sudo apt-get install jq` (Ubuntu/Debian) or `brew install jq` (macOS)

## Resources

- [Linear API Documentation](https://developers.linear.app/docs/)
- [Linear GraphQL API Reference](https://developers.linear.app/docs/graphql/working-with-the-graphql-api)
- [Linear API Explorer](https://linear.app/wecoza/settings/api/explorer)

## Contributing

When adding new features to the Linear CLI:

1. Follow the patterns established in the existing code
2. Update documentation in this README
3. Add best practices to `linear-cli-best-practices.md`
4. Test thoroughly before committing
