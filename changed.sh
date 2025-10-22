mkdir ../changed-files
for file in $(git diff --name-only HEAD~3 HEAD); do
    mkdir -p "../changed-files/$(dirname $file)"
    cp "$file" "../changed-files/$file"
done
