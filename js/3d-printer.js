initCatalogPage({
  getFilterFromText(text) {
    const normalized = (text || '').toLowerCase();

    if (normalized.includes('h2')) return 'h';
    if (normalized.includes('p2') || normalized.includes('p1')) return 'p';
    if (normalized.includes('a1') || normalized.includes('a2')) return 'a';
    if (normalized.includes('x2')) return 'x';

    return '';
  },
  getFilterFromLabel(label) {
    if (label.includes('serie h')) return 'h';
    if (label.includes('serie x')) return 'x';
    if (label.includes('serie p')) return 'p';
    if (label.includes('serie a')) return 'a';

    return '';
  },
});
