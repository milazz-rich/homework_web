initCatalogPage({
  getFilterFromText(text) {
    const normalized = (text || '').toLowerCase();

    if (normalized.includes('lite')) return 'ams lite';
    if (normalized.includes('ht')) return 'ams ht';
    if (normalized.includes('2 pro')) return 'ams 2 pro';
    if (normalized.includes('ams')) return 'ams';

    return '';
  },
  getFilterFromLabel(label) {
    if (label.includes('ams lite')) return 'ams lite';
    if (label.includes('ams ht')) return 'ams ht';
    if (label.includes('2 pro')) return 'ams 2 pro';
    if (label.includes('ams')) return 'ams';

    return '';
  },
});
