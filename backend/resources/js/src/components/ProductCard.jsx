import React from 'react';
import { Box, Card, CardMedia, CardContent, Typography, Button, IconButton } from '@mui/material';
import AddIcon from '@mui/icons-material/Add';
import RemoveIcon from '@mui/icons-material/Remove';

export default function ProductCard(props) {
    const { product} = props;

  return (
    <Card variant="outlined" sx={{ p: 2 }}>
      <CardMedia
        component="img"
        height="160"
        image={product.image}
        alt="Product"
        sx={{ objectFit: 'contain' }}
      />
      <CardContent>
        <Typography variant="subtitle1">{product.name}</Typography>
        <Typography variant="body2" color="text.secondary">{product.price}</Typography>
        <Typography variant="caption" color="text.secondary">Stock: {product.quantity}</Typography>

        <Box sx={{ mt: 1, display: 'flex', alignItems: 'center', gap: 1 }}>
          <IconButton size="small"><RemoveIcon /></IconButton>
          <Typography>1</Typography>
          <IconButton size="small"><AddIcon /></IconButton>
        </Box>
      </CardContent>
    </Card>
  );
};
