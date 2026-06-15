initCatalogPage({
  getFilterFromText(text) {
    const normalized = (text || '').toLowerCase();

    if (normalized.includes('stampanti')) return 'stampanti';
    if (normalized.includes('filamenti')) return 'filamenti';
    if (normalized.includes('accessori')) return 'accessori';
    if (normalized.includes('maker')) return 'makersupply';
    if (normalized.includes('material')) return 'materiali';
    if (normalized.includes('ams')) return 'ams';

    return '';
  },
  getFilterFromLabel(label) {
    if (label.includes('stampanti')) return 'stampanti';
    if (label.includes('filamenti')) return 'filamenti';
    if (label.includes('accessori')) return 'accessori';
    if (label.includes('maker')) return 'makersupply';
    if (label.includes('material')) return 'materiali';
    if (label.includes('ams')) return 'ams';

    return '';
  },
});
