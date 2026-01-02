# How to Push to GitHub - Step by Step

## Step 1: Initialize Git Repository

Open PowerShell/Terminal in your project folder and run:

```powershell
git init
```

## Step 2: Add All Files

```powershell
git add .
```

## Step 3: Make Your First Commit

```powershell
git commit -m "Initial commit: Tanseeq Run Registration System"
```

## Step 4: Create GitHub Repository

1. Go to [GitHub.com](https://github.com) and sign in
2. Click the **"+"** icon in the top right → **"New repository"**
3. Repository name: `tanseeq-run` (or any name you prefer)
4. Description: "Tanseeq Run Registration System"
5. Choose **Public** or **Private** (Private recommended for employee data)
6. **DO NOT** check "Initialize with README" (we already have files)
7. Click **"Create repository"**

## Step 5: Connect to GitHub

After creating the repository, GitHub will show you commands. Use these:

```powershell
git remote add origin https://github.com/YOUR_USERNAME/tanseeq-run.git
```

Replace `YOUR_USERNAME` with your GitHub username.

## Step 6: Push to GitHub

```powershell
git branch -M main
git push -u origin main
```

If asked for credentials:
- **Username**: Your GitHub username
- **Password**: Use a **Personal Access Token** (not your GitHub password)

### How to Create Personal Access Token:
1. GitHub → Settings → Developer settings → Personal access tokens → Tokens (classic)
2. Click "Generate new token (classic)"
3. Give it a name (e.g., "tanseeq-run")
4. Select scopes: Check **"repo"**
5. Click "Generate token"
6. **Copy the token** (you won't see it again!)
7. Use this token as your password when pushing

## Step 7: Verify

Go to your GitHub repository page and refresh. You should see all your files!

---

## Quick Command Summary

```powershell
# Initialize
git init

# Add files
git add .

# Commit
git commit -m "Initial commit: Tanseeq Run Registration System"

# Add remote (replace YOUR_USERNAME)
git remote add origin https://github.com/YOUR_USERNAME/tanseeq-run.git

# Push
git branch -M main
git push -u origin main
```

---

## Important Notes

⚠️ **The Excel file is NOT uploaded** - It's in `.gitignore` to protect employee data
⚠️ **Your `.env` file is NOT uploaded** - Contains sensitive configuration
⚠️ **Vendor folder is NOT uploaded** - Can be reinstalled with `composer install`

---

## Future Updates

When you make changes and want to push:

```powershell
git add .
git commit -m "Description of changes"
git push
```

