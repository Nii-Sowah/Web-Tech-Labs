import os
import re
import subprocess
from datetime import datetime

def get_total_commits():
    try:
        # Counts total commits in the repository
        result = subprocess.run(["git", "rev-list", "--count", "HEAD"], capture_output=True, text=True, check=True)
        return result.stdout.strip()
    except Exception:
        return "N/A"

def generate_toc_and_clean_readme(filepath):
    if not os.path.exists(filepath):
        return "", ""
        
    with open(filepath, "r", encoding="utf-8") as f:
        lines = f.readlines()

    toc_lines = []
    filtered_lines = []
    in_toc_zone = False

    # This loop cleans out any previous auto-generated TOC so it doesn't duplicate
    for line in lines:
        if "<!-- START_TOC -->" in line:
            in_toc_zone = True
            filtered_lines.append(line)
            continue
        if "<!-- END_TOC -->" in line:
            in_toc_zone = False
            filtered_lines.append(line)
            continue
        
        if in_toc_zone:
            continue # Skip reading old TOC content
            
        filtered_lines.append(line)

        # Catch Markdown headers (## Header or ### Subheader) but skip the main # Title
        match = re.match(r"^(##+)\s+(.*)", line)
        if match:
            level = len(match.group(1)) - 2 # Determine indentation level
            header_text = match.group(2).strip()
            
            # Clean up the text to create a working markdown anchor link
            anchor = header_text.lower()
            anchor = re.sub(r"[^\w\s-]", "", anchor) # Remove punctuation
            anchor = re.sub(r"\s+", "-", anchor) # Replace spaces with dashes
            
            indent = "  " * level
            toc_lines.append(f"{indent}- [{header_text}](#{anchor})")

    toc_content = "\n" + "\n".join(toc_lines) + "\n"
    return "".join(filtered_lines), toc_content

def main():
    readme_path = "README.md"
    
    # 1. Strip old TOC out and gather the newly mapped layout headers
    cleaned_readme, new_toc = generate_toc_and_clean_readme(readme_path)
    if not cleaned_readme:
        print("README.md not found!")
        return

    # 2. Gather data for dynamic stats and timestamps
    current_time = datetime.utcnow().strftime("%Y-%m-%d %H:%M:%S UTC")
    total_commits = get_total_commits()
    
    # Count tracked source files as a statistic sample
    total_files = 0
    for root, dirs, files in os.walk("."):
        if ".git" in root or ".github" in root:
            continue
        total_files += len(files)

    # 3. Swap out markers using Regex patterns
    updated_content = cleaned_readme
    
    # Inject Table of Contents
    updated_content = re.sub(
        r"<!-- START_TOC -->.*?<!-- END_TOC -->", 
        f"<!-- START_TOC -->{new_toc}<!-- END_TOC -->", 
        updated_content, 
        flags=re.DOTALL
    )
    
    # Inject Timestamp
    updated_content = re.sub(
        r"<!-- START_TIMESTAMP -->.*?<!-- END_TIMESTAMP -->", 
        f"<!-- START_TIMESTAMP -->{current_time}<!-- END_TIMESTAMP -->", 
        updated_content, 
        flags=re.DOTALL
    )

    # Inject Statistics Panel
    stats_panel = f"\n- **Total Commits:** {total_commits}\n- **Project Files Tracked:** {total_files}\n"
    updated_content = re.sub(
        r"<!-- START_STATS -->.*?<!-- END_STATS -->", 
        f"<!-- START_STATS -->{stats_panel}<!-- END_STATS -->", 
        updated_content, 
        flags=re.DOTALL
    )

    # 4. Write changes back to the root README
    with open(readme_path, "w", encoding="utf-8") as f:
        f.write(updated_content)

if __name__ == "__main__":
    main()
