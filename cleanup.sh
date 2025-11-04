#!/bin/bash

echo "🧹 Cleaning up development files for production deployment..."
echo ""

# Count files before
BEFORE=$(ls -1 *.md 2>/dev/null | wc -l)
echo "📊 Current .md files: $BEFORE"
echo ""

# Ask for confirmation
read -p "⚠️  This will delete 17 development .md files. Continue? (y/n) " -n 1 -r
echo ""

if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    echo "❌ Cleanup cancelled"
    exit 1
fi

echo "🗑️  Deleting status reports..."

# Delete status reports
rm -f 100_PERCENT_COMPLETE.md
rm -f CUSTOMER_IMPLEMENTATION_STATUS.md
rm -f CUSTOMER_MANAGEMENT_COMPLETE.md
rm -f FINAL_STATUS_REPORT.md
rm -f FINAL_VIEWS_NEEDED.md
rm -f IMPLEMENTATION_COMPLETE_SUMMARY.md
rm -f MENU_ITEMS_IMPORTED.md
rm -f PROJECT_SUMMARY.md
rm -f PWA_COMPLETE.md
rm -f SETUP_STATUS.md
rm -f SYSTEM_REVIEW_COMPLETE.md
rm -f TRULY_100_PERCENT_COMPLETE.md

echo "🗑️  Deleting implementation notes..."

# Delete implementation notes
rm -f AUTO_PRINT_IMPLEMENTATION.md
rm -f MYANMAR_TEXT_FIX.md

echo "🗑️  Deleting data files..."

# Delete data files
rm -f items.md
rm -f teahouse-pos.md

echo "🗑️  Deleting cleanup files..."

# Delete this cleanup guide
rm -f DEPLOYMENT_CLEANUP.md

echo "🗑️  Deleting Python development files..."

# Delete Python files
rm -f generate_icons.py
rm -rf venv/

echo "🗑️  Deleting backup files..."

# Delete backup files
find . -name "*.backup" -delete 2>/dev/null
find . -name "*.bak" -delete 2>/dev/null
find . -name "*~" -delete 2>/dev/null

echo ""
echo "✅ Cleanup complete!"
echo ""

# Count files after
AFTER=$(ls -1 *.md 2>/dev/null | wc -l)
echo "📊 Remaining .md files: $AFTER"
echo ""

echo "📋 Kept documentation files:"
ls -1 *.md 2>/dev/null | while read file; do
    echo "   ✅ $file"
done

echo ""
echo "🎉 Your project is now clean and ready for deployment!"
echo ""
echo "📝 Remaining files:"
echo "   - README.md (Main documentation)"
echo "   - INSTALLATION.md (Setup guide)"
echo "   - ADVANCED_FEATURES_GUIDE.md (Feature docs)"
echo "   - DIGITAL_SIGNAGE_GUIDE.md (Optional)"
echo "   - PWA_SETUP_GUIDE.md (Optional)"
echo "   - TAX_SERVICE_CHARGE_GUIDE.md (Optional)"
echo "   - INVENTORY_REPORTS_QUICKSTART.md (Optional)"
echo ""
