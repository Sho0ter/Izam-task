import React from 'react';
import { Box, Typography, Paper, Divider, Button, IconButton } from '@mui/material';
import DeleteIcon from '@mui/icons-material/Delete';

export default function OrderSummary() {
  return (
    <Paper variant="outlined" sx={{ p: 2 }}>
      <Typography variant="h6" gutterBottom>Order Summary</Typography>

      {[1, 2].map((_, i) => (
        <Box key={i} sx={{ display: 'flex', alignItems: 'center', mb: 2 }}>
          <img src="/images/shirt.png" alt="item" style={{ width: 40, height: 40, marginRight: 8 }} />
          <Box sx={{ flexGrow: 1 }}>
            <Typography variant="body2">Gradient Graphic T-shirt</Typography>
            <Typography variant="caption">$145</Typography>
          </Box>
          <Box sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
            <Button size="small">-</Button>
            <Typography>1</Typography>
            <Button size="small">+</Button>
            <IconButton size="small"><DeleteIcon fontSize="small" /></IconButton>
          </Box>
        </Box>
      ))}

      <Divider sx={{ my: 2 }} />
      <Box sx={{ display: 'flex', justifyContent: 'space-between' }}>
        <Typography variant="body2">Subtotal</Typography>
        <Typography variant="body2">$385</Typography>
      </Box>
      <Box sx={{ display: 'flex', justifyContent: 'space-between' }}>
        <Typography variant="body2">Shipping</Typography>
        <Typography variant="body2">$15.00</Typography>
      </Box>
      <Box sx={{ display: 'flex', justifyContent: 'space-between', mb: 2 }}>
        <Typography variant="body2">Tax</Typography>
        <Typography variant="body2">$12.50</Typography>
      </Box>
      <Box sx={{ display: 'flex', justifyContent: 'space-between', fontWeight: 'bold', mb: 2 }}>
        <Typography variant="body1">Total</Typography>
        <Typography variant="body1">$412.50</Typography>
      </Box>
      <Button variant="contained" fullWidth>Proceed to Checkout</Button>
    </Paper>
  );
}